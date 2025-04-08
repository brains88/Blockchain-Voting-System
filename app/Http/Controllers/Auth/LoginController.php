<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Elliptic\EC;
use kornrunner\Keccak;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
         $request->validate([
             'wallet_address' => 'required|string|regex:/^0x[a-fA-F0-9]{40}$/',
             'signature' => 'required|string'
         ]);
         
         $user = User::where('wallet_address', strtolower($request->wallet_address))->first();
         
         if (!$user) {
             return back()->with('error', 'Wallet address not registered');
         }
         
         if (!$user->auth_message) {
             return back()->with('error', 'No authentication message found for this wallet');
         }
         
         if (!$this->verifySignature($user->auth_message, $request->signature, $request->wallet_address)) {
             return back()->with('error', 'Invalid signature');
         }
         
         Auth::login($user);
         
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
