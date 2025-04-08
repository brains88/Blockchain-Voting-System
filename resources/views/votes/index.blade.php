@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Election</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #008751;
            --secondary-color: #6c757d;
            --success-color: #00d97e;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-color);
        }
        
        .voting-header {
            background: linear-gradient(135deg, rgba(44, 123, 229, 0.1) 0%, rgba(255, 255, 255, 1) 100%);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 3rem;
        }
        
        .text-primary{
            color:#008751 !important;
        }

        .vote-icon {
            width: 80px;
            height: 80px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            box-shadow: 0 5px 15px rgba(44, 123, 229, 0.3);
            margin: 0 auto 1.5rem;
        }
        
        .candidate-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .candidate-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(44, 123, 229, 0.1);
        }
        
        .candidate-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            object-position: top;
        }
        
        .party-badge {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-weight: 600;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #008751;
            border-color: #f6851b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .section-title {
            position: relative;
            display: inline-block;
            font-weight: 700;
            color: var(--dark-color);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 4px;
            background-color: var(--primary-color);
            border-radius: 2px;
        }
        
        .modal-candidate-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid var(--primary-color);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin: 0 auto 1.5rem;
            display: block;
        }
        
        .instruction-card {
            background-color: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            border-left: 5px solid var(--primary-color);
            margin-bottom: 2rem;
        }
        
        .step-badge {
            background-color: var(--primary-color);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            flex-shrink: 0;
        }
        
        /* Voting confirmation styles */
        .selected-candidate {
            border: 3px solid #008751;
            box-shadow: 0 0 20px rgba(0, 135, 81, 0.2);
        }

        .voted-badge {
            display: inline-block;
            padding: 8px 20px;
            background-color: #008751;
            color: white;
            border-radius: 50px;
            font-weight: bold;
        }

        .vote-timestamp {
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 15px;
        }

                /* Voted state styles */
                .vote-stats {
            margin: 15px 0;
        }

        .vote-count-badge {
            display: inline-block;
            padding: 8px 15px;
            background-color: #f6851b;
            color: white;
            border-radius: 50px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .vote-count-badge i {
            margin-right: 5px;
        }


                @media (max-width: 768px) {
                    .candidate-image {
                        height: 200px;
                    }
                    
                    .voting-header {
                        padding: 1.5rem;
                    }
                }
    </style>
</head>
<body>
<div class="container-fluid py-5 bg-light">
    <div class="container">
        <!-- Main Header -->
        <div class="voting-header text-center">
            <div class="vote-icon">
                <i class="fas fa-vote-yea"></i>
            </div>
            <h1 class="display-5 fw-bold mb-2" style="color:#008751">University Blockchain Voting</h1>
            <p class="lead text-muted">Cast your vote for the student representatives</p>
        </div>
        
        <!-- Alerts Section -->
        @include('partials.alerts')
        
        @if($voted)
            <!-- Already Voted View -->
            <div class="text-center mb-5">
                <div class="voted-badge mb-4">
                    <i class="fas fa-check-circle me-2"></i>
                    You've Already Voted
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger mb-4">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout & Disconnect Wallet
                    </button>
                </form>
                <h2 class="mb-4">Your Selected Candidate</h2>
                
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="candidate-card card selected-candidate">
                            <!-- Your selected candidate card content -->
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Voting Instructions -->
            @include('partials.voting-instructions')
        @endif
        
        <!-- Candidates Section -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">All Candidates</h2>
                    <div class="text-muted">
                        Showing {{ $candidates->count() }} candidates
                    </div>
                </div>
                
                <div class="row g-4">
                    @foreach($candidates as $candidate)
                        <div class="col-md-6 col-lg-4">
                            <div class="candidate-card card @if($voted && $userVote && $userVote->candidate_id == $candidate->id) selected-candidate @endif">
                                <!-- Candidate Image -->
                                <div class="position-relative">
                                    <img src="{{ $candidate->image ? asset('storage/'.$candidate->image) : 'https://i.pinimg.com/280x280_RS/79/dd/11/79dd11a9452a92a1accceec38a45e16a.jpg' }}" 
                                         alt="{{ $candidate->name }}" 
                                         class="candidate-image">
                                    @if($candidate->party)
                                    <div class="party-badge">
                                        {{ $candidate->party }}
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Candidate Details -->
                                <div class="card-body">
                                    <h3 class="card-title mb-2" style="color:#f6851b">{{ $candidate->name }}</h3>
                                    <p class="card-text text-muted mb-3">{{ Str::limit($candidate->description, 120) }}</p>
                                    
                                    <!-- Vote Count -->
                                    <div class="vote-count-badge mb-3">
                                        <i class="fas fa-vote-yea me-1"></i>
                                        Total Votes: {{ $candidate->votes_count }}
                                    </div>
                                    
                                    @if($voted && $userVote && $userVote->candidate_id == $candidate->id)
                                        <div class="voted-indicator">
                                            <i class="fas fa-check-circle me-1"></i>
                                            You voted for this candidate
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-between align-items-center">
                                            <button class="btn" data-bs-toggle="modal" style="border-color:#f6851b; color:#008751" data-bs-target="#candidateModal{{ $candidate->id }}">
                                                <i class="fas fa-user-circle me-1"></i> Profile
                                            </button>
                                            
                                            @if(!$voted)
                                            <form action="{{ route('votes.store') }}" method="POST" class="vote-form">
                                                @csrf
                                                <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-check-circle me-1"></i> Vote
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Candidate Modal -->
                        @include('partials.candidate-modal', ['candidate' => $candidate])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('resources/js/vote.js') }}"></script>
    <script>
        // Handle logout/disconnect
document.querySelector('form[action="{{ route('logout') }}"]').addEventListener('submit', async function(e) {
e.preventDefault();

try {
   // Show loading state
   const button = this.querySelector('button[type="submit"]');
   const originalText = button.innerHTML;
   button.disabled = true;
   button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Disconnecting...';
   
   // First try to disconnect MetaMask if available
   if (window.ethereum && window.ethereum.isConnected()) {
       try {
           // This is the proper way to "disconnect" in MetaMask
           await window.ethereum.request({
               method: 'wallet_revokePermissions',
               params: [{
                   eth_accounts: {}
               }]
           });
           
           // Clear any cached account access
           await window.ethereum.request({
               method: 'eth_accounts'
           });
       } catch (walletError) {
           console.log('Wallet disconnection warning:', walletError);
           // Continue with logout even if wallet disconnection fails
       }
   }
   
   // Submit the logout form via AJAX
   const response = await fetch(this.action, {
       method: 'POST',
       headers: {
           'Content-Type': 'application/x-www-form-urlencoded',
           'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
           'X-Requested-With': 'XMLHttpRequest'
       },
       body: new URLSearchParams(new FormData(this))
   });
   
   const data = await response.json();
   
   if (data.success) {
       // Redirect to login page after successful logout
       window.location.href = '/login';
   } else {
       throw new Error(data.message || 'Logout failed');
   }
} catch (error) {
   console.error('Logout error:', error);
   alert('Error during logout: ' + error.message);
   
   // Reset button state
   const button = this.querySelector('button[type="submit"]');
   button.disabled = false;
   button.innerHTML = originalText;
}
});

    </script>
</body>
</html>