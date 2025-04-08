<div class="modal fade" id="editCandidateModal" tabindex="-1" aria-labelledby="editCandidateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCandidateModalLabel">
                    <i class="fas fa-user-edit me-2"></i> Edit Candidate
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCandidateForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <!-- Status Message -->
                    <div id="editFormStatus" class="alert d-none"></div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="image-upload-container mb-3">
                                <div class="image-preview" id="editImagePreview">
                                    <img id="editImagePreviewImg" src="" alt="Preview" class="img-fluid rounded">
                                </div>
                                <label for="editImageUpload" class="btn btn-sm btn-outline-secondary mt-2 w-100">
                                    <i class="fas fa-camera me-1"></i> Change Image
                                </label>
                                <input type="file" id="editImageUpload" name="image" class="d-none" accept="image/*">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="edit_name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_name" name="name" required>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_party" class="form-label">Political Party</label>
                                    <input type="text" class="form-control" id="edit_party" name="party">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_party_color" class="form-label">Party Color</label>
                                    <input type="color" class="form-control form-control-color" id="edit_party_color" name="party_color" value="#f6851b">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="editSubmitButton">
                        <span id="editSubmitText">Update Candidate</span>
                        <span id="editSubmitSpinner" class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>