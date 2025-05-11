<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Elliptic\EC;
use kornrunner\Keccak;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    //
     // Show login form
            public function showLoginForm()
            {
                return view('auth.login');
            }
        
            public function getNonce(Request $request)
            {
                try {
                    $request->validate([
                        'wallet_address' => 'required|string|regex:/^0x[a-fA-F0-9]{40}$/'
                    ]);
                    
                    // Generate a persistent message with unique ID
                    $authMessage = "Welcome to Nigeria Voting Platform! By signing this message, you authenticate your identity. Unique ID: " . Str::random(8);
                    
                    User::updateOrCreate(
                        ['wallet_address' => strtolower($request->wallet_address)],
                        ['auth_message' => $authMessage]
                    );
                    
                    return response()->json(['message' => $authMessage]);
                    
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Failed to generate authentication message'], 500);
                }
            }
     
            public function authenticate(Request $request)
            {
                \Log::info('Authentication request received', ['request_data' => $request->all()]);

                try {
                    $request->validate([
                        'auth_method' => 'required|in:wallet,voter_id',
                    ]);

                    if ($request->auth_method === 'wallet') {
                        return $this->handleWalletAuth($request);
                    } else {
                        return $this->handleVoterIdAuth($request);
                    }
                } catch (\Exception $e) {
                    \Log::error('Authentication process failed', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    return back()->with('error', 'Authentication failed: ' . $e->getMessage());
                }
            }

            protected function handleWalletAuth(Request $request)
            {
                \Log::debug('Starting wallet authentication', ['wallet' => $request->wallet_address]);

                $request->validate([
                    'wallet_address' => 'required|string|regex:/^0x[a-fA-F0-9]{40}$/',
                    'signature' => 'required|string'
                ]);

                $walletAddress = strtolower($request->wallet_address);
                
                // Try to find existing user
                $user = User::where('wallet_address', $walletAddress)->first();
                \Log::debug('User lookup result', ['user_exists' => !is_null($user)]);

                // If user doesn't exist, create new voter
                if (!$user) {
                    \Log::debug('Attempting to create new wallet user');
                    try {
                        $user = User::create([
                            'wallet_address' => $walletAddress,
                            'auth_method' => 'wallet',
                            'role' => 'voter',
                            'is_verified' => true
                        ]);
                        \Log::info('New wallet user created', ['user_id' => $user->id]);
                    } catch (\Exception $e) {
                        \Log::error('Failed to create wallet user', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        throw $e;
                    }
                }

                // Verify signature
                if (!$this->verifySignature($user->auth_message, $request->signature, $request->wallet_address)) {
                    \Log::warning('Invalid signature provided', ['wallet' => $walletAddress]);
                    return back()->with('error', 'Invalid signature');
                }

                Auth::login($user);
                \Log::info('User authenticated via wallet', ['user_id' => $user->id]);
                return redirect()->route('votes.index');
            }

            protected function handleVoterIdAuth(Request $request)
            {
                \Log::debug('Starting voter ID authentication', ['voter_id' => $request->voter_id]);

                $request->validate([
                    'voter_id' => 'required|string',
                    'dob' => 'required|date|before_or_equal:-18 years',
                ]);

                // Verify age
                $dob = new \DateTime($request->dob);
                $today = new \DateTime();
                $age = $today->diff($dob)->y;
                \Log::debug('Age verification', ['age' => $age, 'dob' => $request->dob]);
                
                if ($age < 18) {
                    \Log::warning('Age verification failed', ['age' => $age]);
                    return back()->with('error', 'You must be at least 18 years old to vote');
                }

                // Try to find existing user
                $user = User::where('voter_id', $request->voter_id)->first();
                \Log::debug('Voter lookup result', ['user_exists' => !is_null($user)]);

                // If user doesn't exist, create new voter
                if (!$user) {
                    \Log::debug('Attempting to create new voter ID user');
                    try {
                        $user = User::create([
                            'voter_id' => $request->voter_id,
                            'date_of_birth' => $request->dob,
                            'auth_method' => 'voter_id',
                            'role' => 'voter',
                            'is_verified' => true
                        ]);
                        \Log::info('New voter ID user created', ['user_id' => $user->id]);
                    } catch (\Exception $e) {
                        \Log::error('Failed to create voter ID user', [
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                            'input_data' => $request->all()
                        ]);
                        throw $e;
                    }
                } else {
                    // For existing users, verify details match
                    \Log::debug('Existing user found, verifying details');
                    if ($user->date_of_birth != $request->dob) {
                        \Log::warning('DOB mismatch for existing user', [
                            'stored_dob' => $user->date_of_birth,
                            'provided_dob' => $request->dob
                        ]);
                        return back()->with('error', 'Date of birth does not match our records');
                    }
                }

                Auth::login($user);
                \Log::info('User authenticated via voter ID', ['user_id' => $user->id]);
                return redirect()->route('votes.index');
            }

        protected function verifySignature(string $message, string $signature, string $address): bool
        {
            try {
                // Basic validation
                if (strlen($signature) !== 132 || !str_starts_with($signature, '0x')) {
                    return false;
                }

                $hash = Keccak::hash(sprintf("\x19Ethereum Signed Message:\n%s%s", strlen($message), $message), 256);
                
                $signature = str_replace(['0x', '0X'], '', $signature);
                
                if (strlen($signature) !== 130) {
                    return false;
                }

                $r = substr($signature, 0, 64);
                $s = substr($signature, 64, 64);
                $v = ord(hex2bin(substr($signature, 128, 2))) - 27;

                if ($v != ($v & 1)) {
                    return false;
                }

                $ec = new EC('secp256k1');
                $publicKey = $ec->recoverPubKey($hash, ['r' => $r, 's' => $s], $v);
                
                $recoveredAddress = '0x' . substr(Keccak::hash(substr(hex2bin($publicKey->encode('hex')), 1), 256), 24);

                return strtolower($address) === strtolower($recoveredAddress);
            } catch (\Exception $e) {
                \Log::error('Signature verification failed', ['error' => $e->getMessage()]);
                return false;
            }
        }
     // Handle logout
     public function logout(Request $request)
     {
         // Clear the authentication session
         Auth::logout();
         
         // Invalidate the session
         $request->session()->invalidate();
         
         // Regenerate CSRF token
         $request->session()->regenerateToken();
         
         // Return a response that will trigger client-side disconnection
         return response()->json([
             'success' => true,
             'message' => 'Logged out successfully'
         ]);
     }
}
