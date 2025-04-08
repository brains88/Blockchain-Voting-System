@extends('layouts.admin')

@section('content')
<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center py-3">
                <div class="d-flex align-items-center">
                    <div class="admin-logo me-3">
                        <i class="fas fa-vote-yea"></i>
                    </div>
                    <div>
                        <h1 class="mb-0">Voting System Admin</h1>
                        <small class="text-white-50">Manage candidates and monitor votes</small>
                    </div>
                </div>
                <div class="total-votes-badge">
                    <span class="badge-count">{{ number_format($totalVotes) }}</span>
                    <span class="badge-label">Total Votes</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mb-4 flex-wrap">
            <div class="admin-actions mb-2 mb-md-0">
                <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#createCandidateModal">
                    <i class="fas fa-user-plus me-1"></i> Add Candidate
                </button>
                <button class="btn btn-outline-light">
                    <i class="fas fa-file-export me-1"></i> Export Results
                </button>
            </div>
            
            <div class="admin-search">
            <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger mb-4">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(0, 135, 81, 0.1);">
                        <i class="fas fa-users" style="color: #008751;"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $candidates->count() }}</h3>
                        <p>Candidates</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(255, 193, 7, 0.1);">
                        <i class="fas fa-chart-line" style="color: #FFC107;"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $totalVotes > 0 ? round(($candidates->max('votes_count') / $totalVotes) * 100, 1) : 0 }}%</h3>
                        <p>Leading By</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(33, 150, 243, 0.1);">
                        <i class="fas fa-user-tie" style="color: #2196F3;"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $candidates->where('votes_count', $candidates->max('votes_count'))->count() }}</h3>
                        <p>Leaders</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: rgba(233, 30, 99, 0.1);">
                        <i class="fas fa-user-clock" style="color: #E91E63;"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $candidates->where('votes_count', 0)->count() }}</h3>
                        <p>No Votes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Candidates Table -->
        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2"></i> Candidates
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th style="width: 50px;">Rank</th>
                                <th>Candidate</th>
                                <th>Party</th>
                                <th class="text-center">Votes</th>
                                <th class="text-center">Vote %</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($candidates as $index => $candidate)
                            <tr>
                                <td class="align-middle">
                                    <div class="rank-badge @if($index < 3) top-{{ $index + 1 }} @endif">
                                        {{ $index + 1 }}
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <div class="d-flex align-items-center">
                                        <div class="candidate-avatar me-3">
                                            <img src="{{ $candidate->image ? asset('storage/'.$candidate->image) : 'https://i.pinimg.com/280x280_RS/79/dd/11/79dd11a9452a92a1accceec38a45e16a.jpg' }}"
                                                 alt="{{ $candidate->name }}" 
                                                 class="rounded-circle">
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $candidate->name }}</div>
                                            <small class="text-muted">{{ Str::limit($candidate->description, 50) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    @if($candidate->party)
                                    <span class="party-badge" style="background-color: {{ $candidate->party_color ?? '#f6851b' }}">
                                        {{ $candidate->party }}
                                    </span>
                                    @else
                                    <span class="party-badge" style="background-color: #6c757d">Independent</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center fw-bold">
                                    {{ number_format($candidate->votes_count) }}
                                </td>
                                <td class="align-middle">
                                    @php
                                        $percentage = $totalVotes > 0 ? ($candidate->votes_count / $totalVotes) * 100 : 0;
                                    @endphp
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                            <div class="progress-bar" 
                                                 role="progressbar" 
                                                 style="width: {{ $percentage }}%;" 
                                                 aria-valuenow="{{ $percentage }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ round($percentage, 1) }}%</small>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-primary edit-candidate" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editCandidateModal"
                                                data-id="{{ $candidate->id }}"
                                                data-name="{{ $candidate->name }}"
                                                data-party="{{ $candidate->party }}"
                                                data-description="{{ $candidate->description }}"
                                                data-image="{{ $candidate->image ? asset('storage/'.$candidate->image) : '' }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('admin.candidates.delete', $candidate->id) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this candidate?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Create Candidate Modal -->
@include('admin.partials.create')

<!-- Edit Candidate Modal -->
@include('admin.partials.edit')


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ========== IMAGE PREVIEW HANDLING ==========
    const createImageUpload = document.getElementById('createImageUpload');
    const createImagePreviewImg = document.getElementById('createImagePreviewImg');
    const editImageUpload = document.getElementById('editImageUpload');
    const editImagePreviewImg = document.getElementById('editImagePreviewImg');
    
    function handleImagePreview(event) {
        const file = event.target.files[0];
        if (!file) return;
        
        const reader = new FileReader();
        reader.onload = function(e) {
            if (event.target.id === 'createImageUpload') {
                createImagePreviewImg.src = e.target.result;
            } else if (event.target.id === 'editImageUpload') {
                editImagePreviewImg.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }

    if (createImageUpload) createImageUpload.addEventListener('change', handleImagePreview);
    if (editImageUpload) editImageUpload.addEventListener('change', handleImagePreview);

    // ========== FORM SUBMISSION HANDLING ==========
    async function handleFormSubmit(e, isEditForm = false) {
        e.preventDefault();
        
        const form = e.target;
        const formId = form.id;
        const submitButton = form.querySelector('button[type="submit"]');
        const submitText = form.querySelector('.submit-text');
        const submitSpinner = form.querySelector('.submit-spinner');
        const formStatus = document.getElementById(`${formId}Status`);
        
        // Show loading state
        submitButton.disabled = true;
        if (submitText) submitText.textContent = isEditForm ? 'Updating...' : 'Saving...';
        if (submitSpinner) submitSpinner.classList.remove('d-none');
        if (formStatus) formStatus.classList.add('d-none');
        
        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-HTTP-Method-Override': isEditForm ? 'PUT' : 'POST'
                }
            });

            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || (isEditForm ? 'Failed to update candidate' : 'Failed to create candidate'));
            }

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: data.message || (isEditForm ? 'Candidate updated successfully!' : 'Candidate created successfully!'),
                timer: 3000,
                showConfirmButton: false
            }).then(() => {
                const modalId = isEditForm ? 'editCandidateModal' : 'createCandidateModal';
                const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
                if (modal) modal.hide();
                window.location.reload();
            });
            
        } catch (error) {
            if (formStatus) {
                formStatus.classList.remove('d-none', 'alert-success');
                formStatus.classList.add('alert-danger');
                formStatus.textContent = error.message || 'An error occurred while processing your request.';
                formStatus.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'An error occurred'
                });
            }
        } finally {
            if (submitButton) submitButton.disabled = false;
            if (submitText) submitText.textContent = isEditForm ? 'Update Candidate' : 'Save Candidate';
            if (submitSpinner) submitSpinner.classList.add('d-none');
        }
    }

    // Create form
    const createCandidateForm = document.getElementById('createCandidateForm');
    if (createCandidateForm) {
        createCandidateForm.addEventListener('submit', (e) => handleFormSubmit(e, false));
    }
    
    // Edit form
    const editCandidateForm = document.getElementById('editCandidateForm');
    if (editCandidateForm) {
        editCandidateForm.addEventListener('submit', (e) => handleFormSubmit(e, true));
    }

    // ========== EDIT MODAL POPULATION ==========
    const editButtons = document.querySelectorAll('.edit-candidate');
    if (editButtons) {
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const candidateId = this.getAttribute('data-id');
                const candidateName = this.getAttribute('data-name');
                const candidateParty = this.getAttribute('data-party');
                const candidateDescription = this.getAttribute('data-description');
                const candidateImage = this.getAttribute('data-image');
                const partyColor = this.getAttribute('data-party-color') || '#f6851b';
                
                // Set form action
                const editForm = document.getElementById('editCandidateForm');
                editForm.action = `/admin/candidates/${candidateId}`;
                
                // Populate form fields
                document.getElementById('edit_name').value = candidateName;
                document.getElementById('edit_party').value = candidateParty || '';
                document.getElementById('edit_party_color').value = partyColor;
                document.getElementById('edit_description').value = candidateDescription || '';
                
                // Set image preview
                editImagePreviewImg.src = candidateImage || 'https://i.pinimg.com/280x280_RS/79/dd/11/79dd11a9452a92a1accceec38a45e16a.jpg';
            });
        });
    }


    // ========== FLASH MESSAGE HANDLING ==========
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif
    
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}'
        });
    @endif
});
</script>
@endsection