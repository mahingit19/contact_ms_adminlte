<!-- Vertically centered scrollable modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registration Form</h1>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate>
                    <input type="hidden" id="formId" name="id">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="firstName" class="form-label">First Name <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter your first name" required>
                            <div class="invalid-feedback">Please enter your first name.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="lastName" class="form-label">Last Name <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter your last name" required>
                            <div class="invalid-feedback">Please enter your last name.</div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                        <div class="invalid-feedback">Please provide a valid email address.</div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone (+880) <span class="text-danger fw-bold">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number after (+880)" pattern="[0-9]+" required>
                        <div class="invalid-feedback">Please enter exactly 10 digits after +880 (e.g., "XXXXXXXXXX").</div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address <span class="text-danger fw-bold">*</span></label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" required>
                        <div class="invalid-feedback">Please provide your address.</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="city" class="form-label">City <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                            <div class="invalid-feedback">Please enter your city.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="State">
                            <div class="invalid-feedback">Please enter your state.</div>
                        </div>
                        <div class="col-md-4">
                            <label for="zip" class="form-label">ZIP <span class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" id="zip" name="zip" placeholder="ZIP" pattern="[0-9]+" required>
                            <div class="invalid-feedback">Please enter a valid ZIP code (numbers only).</div>
                        </div>
                    </div>
                    <div class="mb-3 mb-3">
                        <label for="country" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" name="country" placeholder="Country">
                        <div class="invalid-feedback">Please enter your country.</div>
                    </div>
                    <div class="mb-3 mb-3">
                        <div class="fullscreen-drop" id="fullscreenDrop">
                            <h5 class="text-dark">Drop your image here!</h5>
                        </div>
                        <div class="mb-3">
                            <label for="imageInput" class="form-label">Upload Your Image</label>
                            <div class="upload-area" id="uploadArea">
                                Drag and drop an image here or click to upload
                                <input type="file" class="form-control myhidden" id="imageInput" accept="image/*">
                            </div>
                        </div>
                        <div class="image-preview" id="imagePreview" style="display: none;">
                            <button type="button" class="btn-close remove-button" id="removeButton" aria-label="Remove">X</button>
                            <img src="" id="previewImage" class="img-fluid" alt="Preview">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary update-btn" id="submit-button">Submit</button>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="/<?= $APP_NAME ?>/assets/custom/js/form-modal-js.js"></script>