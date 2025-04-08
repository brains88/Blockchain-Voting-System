<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Vote;
use App\Services\BlockchainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
   

    public function index()
    {
        $user = Auth::user();
        
        // Get all candidates with vote counts
        $candidates = Candidate::withCount('votes')->get();
        
        // Check if user has already voted
        $existingVote = Vote::with('candidate')->where('user_id', $user->id)->first();
        
        return view('votes.index', [
            'voted' => $existingVote ? true : false,
            'candidates' => $candidates,
            'userVote' => $existingVote // Pass the user's vote if exists
        ]);
    }
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Verify user hasn't already voted
        if (Vote::where('user_id', $user->id)->exists()) {
            return redirect()->route('votes.index')
                ->with('error', 'You have already voted!');
        }
        
        // Validate request
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id'
        ]);
        
        // Record vote on blockchain (optional - implement your blockchain logic here)
        // $txHash = $this->recordVoteOnBlockchain($user->wallet_address, $request->candidate_id);
        
        // Create vote record
        $vote = Vote::create([
            'user_id' => $user->id,
            'candidate_id' => $request->candidate_id,
            // 'tx_hash' => $txHash ?? null // Store blockchain transaction hash if using
        ]);
        
        return redirect()->route('votes.index')
            ->with('success', 'Your vote for ' . $vote->candidate->name . ' has been recorded!');
    }
}