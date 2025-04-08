
                        <!-- Candidate Modal -->
                        <div class="modal fade" id="candidateModal{{ $candidate->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header text-white" style="background-color:#008751;">
                                        <h3 class="modal-title">{{ $candidate->name }}</h3>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="{{ !empty($candidate->image) ? asset('storage/'.$candidate->image) : 'https://i.pinimg.com/280x280_RS/79/dd/11/79dd11a9452a92a1accceec38a45e16a.jpg' }}" 
                                        alt="{{ $candidate->name }}" 
                                             class="modal-candidate-img">
                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                @if($candidate->party)
                                                <div class="mb-4">
                                                    <h5 class="text-primary mb-3">Affiliation</h5>
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge me-2" style="background-color: #f6851b">{{ $candidate->party }}</span>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <div class="mb-4">
                                                    <h5 class="text-primary mb-3">Key Points</h5>
                                                    <ul class="list-unstyled">
                                                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Leadership Experience</li>
                                                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Academic Excellence</li>
                                                        <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Student Advocacy</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <h5 class="mb-3" style="color:#008751;">Candidate Statement</h5>
                                                <p class="mb-4">{{ $candidate->description }}</p>
                                                
                                                <div class="alert alert-primary">
                                                    <i class="fas fa-exclamation-circle me-2"></i>
                                                    Verify your selection before voting
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                                        <form action="{{ route('votes.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-vote-yea me-1"></i> Vote for {{ $candidate->name }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
               