<style>
/* Loading Spinner */
.btn-loading .spinner-border {
    display: inline-block !important;
    margin-left: 5px;
}

/* Image Preview */
.image-preview {
    width: 100%;
    height: 200px;
    border: 2px dashed #dee2e6;
    border-radius: 10px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    background-color: #f8f9fa;
}

.image-preview img {
    max-width: 100%;
    max-height: 100%;
    object-fit: cover;
}

/* Status Alert */
#formStatus.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
}

#formStatus.alert-success {
    background-color: #d4edda;
    color: #155724;
    border-color: #c3e6cb;
}

/* Modal Enhancements */
.modal-content {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #eee;
}

.modal-footer {
    border-top: 1px solid #eee;
}
</style>

<div class="modal fade" id="createCandidateModal" tabindex="-1" aria-labelledby="createCandidateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCandidateModalLabel">
                    <i class="fas fa-user-plus me-2"></i> Add New Candidate
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createCandidateForm" action="{{ route('admin.candidates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Status Message -->
                    <div id="formStatus" class="alert d-none"></div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="image-upload-container mb-3">
                                <div class="image-preview" id="createImagePreview">
                                    <img id="createImagePreviewImg" src="https://i.pinimg.com/280x280_RS/79/dd/11/79dd11a9452a92a1accceec38a45e16a.jpg" alt="Preview" class="img-fluid rounded">
                                </div>
                                <label for="createImageUpload" class="btn btn-sm btn-outline-secondary mt-2 w-100">
                                    <i class="fas fa-camera me-1"></i> Upload Image
                                </label>
                                <input type="file" id="createImageUpload" name="image" class="d-none" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="party" class="form-label">Political Party</label>
                                    <input type="text" class="form-control" id="party" name="party">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="party_color" class="form-label">Party Color</label>
                                    <input type="color" class="form-control form-control-color" id="party_color" name="party_color" value="#f6851b">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success" id="submitButton">
                        <span id="submitText">Save Candidate</span>
                        <span id="submitSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>