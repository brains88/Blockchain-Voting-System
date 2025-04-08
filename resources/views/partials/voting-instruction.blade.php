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
                <h2 class="mb-4">Your Selected Candidate</h2>
                
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="candidate-card card selected-candidate">
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
                            
                            <div class="card-body text-center">
                                <h3 class="card-title mb-2" style="color:#f6851b">{{ $candidate->name }}</h3>
                                <p class="card-text text-muted mb-3">{{ $candidate->description }}</p>
                                
                                <div class="vote-timestamp">
                                    <i class="fas fa-clock me-1"></i>
                                    Voted on: {{ $vote->created_at->format('M j, Y \a\t g:i a') }}
                                </div>
                                
                                <div class="mt-4">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="fas fa-sign-out-alt me-1"></i> Logout & Disconnect Wallet
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Voting Instructions -->
            <div class="instruction-card">
                <!-- Your existing instructions code -->
            </div>
            
            <!-- Candidates Section -->
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="section-title">Candidates</h2>
                        <div class="text-muted">
                            Showing {{ $candidates->count() }} candidates
                        </div>
                    </div>
                    
                    <div class="row g-4">
                        @foreach($candidates as $candidate)
                            <!-- Your existing candidate card code -->
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>