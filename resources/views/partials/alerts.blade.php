@if(session('success'))
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center">
    <i class="fas fa-check-circle me-3 fa-2x"></i>
    <div>
        <h4 class="alert-heading mb-1">Vote Submitted Successfully!</h4>
        <p class="mb-0">{{ session('success') }}</p>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center">
    <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
    <div>
        <h4 class="alert-heading mb-1">Voting Error</h4>
        <p class="mb-0">{{ session('error') }}</p>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif