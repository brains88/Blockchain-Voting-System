<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $candidates = Candidate::withCount('votes')->orderBy('votes_count', 'desc')->get();
        
        return view('admin.index', [
            'candidates' => $candidates,
            'totalVotes' => $candidates->sum('votes_count')
        ]);
    }

 
    public function storeCandidate(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'party' => 'nullable|string|max:255',
                'party_color' => 'nullable|string|max:7',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
    
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('candidates', 'public');
            }
    
            Candidate::create($validated);
    
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Candidate created successfully!'
                ]);
            }
    
            return redirect()->route('admin.dashboard')
                   ->with('success', 'Candidate created successfully!');
                   
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error creating candidate: ' . $e->getMessage()
                ], 500);
            }
    
            return redirect()->back()
                   ->withInput()
                   ->with('error', 'Error creating candidate: ' . $e->getMessage());
        }
    }


    public function updateCandidate(Request $request, Candidate $candidate)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'party' => 'nullable|string|max:255',
                'party_color' => 'nullable|string|max:7',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);
    
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($candidate->image) {
                    Storage::disk('public')->delete($candidate->image);
                }
                $validated['image'] = $request->file('image')->store('candidates', 'public');
            }
    
            $candidate->update($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'Candidate updated successfully!'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating candidate: ' . $e->getMessage()
            ], 500);
        }
    }
    public function deleteCandidate(Candidate $candidate)
    {
        if ($candidate->image) {
            Storage::disk('public')->delete($candidate->image);
        }
        
        $candidate->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'Candidate deleted successfully!');
    }
}