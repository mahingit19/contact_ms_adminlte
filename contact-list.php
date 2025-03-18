<?php

require_once "includes/functions.php";

include "layout/header.php";

?>

<body class="hold-transition skin-blue sidebar-mini">

    <div class="wrapper">

        <?php
        include "layout/main-header.php";
        include "layout/sidebar.php";
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Contact List
                    <small>Total Contacts <span id="total"></span></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Contact List</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="box">

                            <div class="box-header" style="display: flex;">
                                <h3 class="box-title">Contact Table</h3>
                                <input id="mySearch" type="text" placeholder="search anything..." style="margin-left: auto;">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" id="addNewBtn" style="margin-left: auto;">
                                    <i class="bi bi-person-plus-fill"></i> Add New Contact
                                </button>
                            </div>
                            <!-- /.box-header -->


                            <div class="box-body table-responsive no-padding">
                                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">

                                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">

                                        <thead>
                                            <tr role="row">
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">ID</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Image</th>
                                                <th class="sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" aria-sort="descending">Full Name</th>
                                                <th class="sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" aria-sort="descending">Gender</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Email</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Phone</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Address</th>
                                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="table-body">
                                            <!-- Table data goes here -->
                                        </tbody>

                                    </table>

                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>

            </section>

        </div>

        <?php
        include "layout/main-footer.php";
        include "layout/control-sidebar.php";
        ?>

    </div>
    <!-- /.content -->

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
                                <label for="firstName" class="form-label">First Name <span
                                        class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control" id="firstName" name="firstName"
                                    placeholder="Enter your first name" required>
                                <div class="invalid-feedback">Please enter your first name.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name <span
                                        class="text-danger fw-bold">*</span></label>
                                <input type="text" class="form-control" id="lastName" name="lastName"
                                    placeholder="Enter your last name" required>
                                <div class="invalid-feedback">Please enter your last name.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label>Gender <span
                                        class="text-danger fw-bold">*</span></label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="male">male</option>
                                    <option value="female">female</option>
                                </select>
                                <div class="invalid-feedback">Please fill out this field</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                            <div class="invalid-feedback">Please provide a valid email address.</div>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone (+880) <span
                                    class="text-danger fw-bold">*</span></label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                placeholder="Enter your phone number after (+880)" pattern="[0-9]+" required>
                            <div class="invalid-feedback">Please enter exactly 10 digits after +880 (e.g., "XXXXXXXXXX").
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address <span
                                    class="text-danger fw-bold">*</span></label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Enter your address" required>
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
                                <input type="text" class="form-control" id="zip" name="zip" placeholder="ZIP"
                                    pattern="[0-9]+" required>
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
                                <button type="button" class="btn-close remove-button" id="removeButton"
                                    aria-label="Remove">X</button>
                                <img id="previewImage" class="img-fluid" alt="Preview">
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
    <?php
    include "layout/footer.php";
    ?>

    <script>
        "use strict";
        // jquery scripts starts
        $(document).ready(function() {

            //contact-list scripts starts

            // Load table data using AJAX start
            function loadTableData() {
                $.ajax({
                    url: window.location.href, // Path to your PHP script
                    method: "POST",
                    data: {
                        action: "readContacts",
                    },
                    dataType: "json",
                    success: function(response) {
                        let data = response.data;
                        let rows = "";
                        data.forEach((item) => {
                            rows += `<tr>
                                        <td class="id">${item.id}</td>
                                        <td class="image-path" data-src="${item.photo}"><img src="${item.photo}" width="50px"></td>
                                        <td><span class="first-name">${item.first_name}</span> <span class="last-name">${item.last_name}</span></td>
                                        <td class="gender">${item.gender}</td>
                                        <td class="email">${item.email}</td>
                                        <td>+880<span class="phone">${item.phone}</span></td>
                                        <td><span class="address">${item.address}</span>, <span class="city">${item.city}</span>, <span class="state">${item.state}</span>, <span class="zip">${item.zip}</span>, <span class="country">${item.country}</span></td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-primary edit-btn"><i class="bi bi-pencil-square"></i></button>
                                                <button class="btn btn-danger delete-btn" data-id="${item.id}"><i class="bi bi-trash3-fill"></i></button>
                                            </div>
                                        </td>
                                    </tr>`;
                        });
                        $("#table-body").html(rows);
                        $("#total").html($(data).length);
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred:", error);
                    },
                });
            }

            loadTableData(); // Load table data on page load
            // Load table data using AJAX end

            // jquery search starts
            $("#mySearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#table-body tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
            // jquery search ends

            // Use event delegation for delete buttons
            $(document).on("click", ".delete-btn", function() {
                const button = $(this); // Reference to the clicked button
                const id = button.data("id");
                if (confirm("Are you sure you want to delete this row?")) {
                    $.ajax({
                        url: window.location.href, // PHP script to handle the data
                        type: "POST",
                        data: {
                            id: id,
                            action: "deleteContact",
                        },
                        success: function(response) {
                            if (response.status === "success") {
                                alert(response.message);
                                button.closest("tr").remove(); // Remove the row from the table
                                loadTableData(); // Refresh the table
                            } else {
                                alert("Data not deleted: " + response);
                            }

                        },
                        error: function(xhr, status, error) {
                            alert("An error occurred: " + error);
                        },
                    });
                }
            });
            //contact-list scripts ends

            //form modal scripts starts
            
            // Hide all invalid-feedback initially
            $(".invalid-feedback").hide();

            // When the modal is hidden, reset the form
            $("#exampleModal").on("hidden.bs.modal", function() {
                // Reset the form fields
                $(this).find("form")[0].reset();

                // Remove custom validation classes
                $(this).find("form").removeClass("was-validated");

                // Clear custom error messages if present
                $(this).find(".invalid-feedback").hide();
                $(this).find(".is-invalid").removeClass("is-invalid");
                previewImage.src = "";
                imagePreview.style.display = "none";
                imageInput.value = ""; // Clear the file input
            });

            // drag and drop scripts starts
            const uploadArea = document.getElementById("uploadArea");
            const imageInput = document.getElementById("imageInput");
            const imagePreview = document.getElementById("imagePreview");
            const previewImage = document.getElementById("previewImage");
            const removeButton = document.getElementById("removeButton");
            const fullscreenDrop = document.getElementById("fullscreenDrop");

            // Handle click on upload area
            uploadArea.addEventListener("click", () => imageInput.click());

            // Handle fullscreen drag and drop
            window.addEventListener("dragover", (event) => {
                event.preventDefault();
                fullscreenDrop.classList.add("active");
            });

            window.addEventListener("dragleave", (event) => {
                if (!event.relatedTarget || event.relatedTarget === document.body) {
                    fullscreenDrop.classList.remove("active");
                }
            });

            window.addEventListener("drop", (event) => {
                event.preventDefault();
                fullscreenDrop.classList.remove("active");
                const file = event.dataTransfer.files[0];
                if (file) {
                    handleFile(file);
                    updateFileInput(file);
                }
            });

            // Handle file input change
            imageInput.addEventListener("change", () => {
                const file = imageInput.files[0];
                handleFile(file);
            });

            // Function to display preview
            function handleFile(file) {
                if (file && file.type.startsWith("image/")) {
                    const reader = new FileReader();
                    reader.onload = () => {
                        previewImage.src = reader.result;
                        imagePreview.style.display = "block";
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Function to update the file input field programmatically
            function updateFileInput(file) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                imageInput.files = dataTransfer.files;
            }

            // Handle remove button click
            removeButton.addEventListener("click", () => {
                previewImage.src = "";
                imagePreview.style.display = "none";
                imageInput.value = ""; // Clear the file input
            });
            // drag and drop scripts ends

            // Image preview functionality (optional, based on your HTML)
            $("#imageInput").on("change", function() {
                const input = this;
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $("#previewImage").attr("src", e.target.result);
                        $("#imagePreview").show();
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });

            // Remove image preview
            $("#removeButton").on("click", function() {
                $("#imagePreview").hide();
                $("#previewImage").attr("src", "");
                $("#imageInput").val("");
            });

            // Show form for "Add New"
            $(document).on("click", "#addNewBtn", function() {
                $("#exampleModalLabel").text("Add New Record"); // Update modal title
                $("#submit-button").text("Add").data("action", "add"); // Set action to "add"
                $(".needs-validation")[0].reset(); // Clear form fields
                $(".needs-validation").removeClass("was-validated"); // Reset validation
                $("#exampleModal").modal("show"); // Show the modal
            });

            // Show form for "Edit"
            $(document).on("click", ".edit-btn", function() {
                const row = $(this).closest("tr");
                const rowData = {
                    id: row.find(".id").text(), // Assuming the table row has a class "id" for the ID
                    firstName: row.find(".first-name").text(), // Row data
                    lastName: row.find(".last-name").text(),
                    gender: row.find(".gender").text(),
                    email: row.find(".email").text(),
                    phone: row.find(".phone").text(),
                    address: row.find(".address").text(),
                    city: row.find(".city").text(),
                    state: row.find(".state").text(),
                    zip: row.find(".zip").text(),
                    country: row.find(".country").text(),
                    imagePath: row.find(".image-path").data(
                        "src"), // Assuming the image path is stored in a data attribute
                };

                $("#exampleModalLabel").text("Edit Record"); // Update modal title
                $("#submit-button").text("Update").data("action", "edit"); // Set action to "edit"
                $("#formId").val(rowData.id); // Set the ID value
                $("#firstName").val(rowData.firstName); // Populate form fields
                $("#lastName").val(rowData.lastName);
                $("#gender").val(rowData.gender);
                $("#email").val(rowData.email);
                $("#phone").val(rowData.phone);
                $("#address").val(rowData.address);
                $("#city").val(rowData.city);
                $("#state").val(rowData.state);
                $("#zip").val(rowData.zip);
                $("#country").val(rowData.country);

                // Handle the image preview
                if (rowData.imagePath) {
                    $("#imagePreview").show(); // Show the image preview container
                    $("#previewImage").attr("src", rowData.imagePath).show(); // Show existing image
                    $("#removeButton").show(); // Show the remove button
                } else {
                    imageInput.value = ""; // Clear the file input
                    $("#previewImage").hide();
                    $("#removeButton").hide();
                }

                $("#exampleModal").modal("show"); // Show the modal
            });

            // Handle form submission (Add or Edit)
            $(document).on("click", "#submit-button", function(event) {
                event.preventDefault(); // Prevent form's default behavior

                const form = $(".needs-validation")[0]; // Select the form
                const phoneInput = $("#phone").val(); // Get the phone input value
                const phoneRegex = /^\d{10}$/; // Regular expression for exactly 10 digits

                let isValid = true; // Track overall validity

                // Check each input field
                $(form)
                    .find("input, textarea, select")
                    .each(function() {
                        const input = $(this);
                        const formGroup = input.closest(".form-group");
                        const feedback = input.next(".invalid-feedback");

                        // Check if the input is valid
                        if (input[0].checkValidity()) {
                            // If valid, show green border
                            feedback.hide();
                        } else {
                            // If invalid, show red border and message
                            feedback.text(input[0].validationMessage).show();
                            isValid = false;
                        }
                    });

                // Phone number validation
                if (!phoneRegex.test(phoneInput)) {
                    $("#phone")
                        .next(".invalid-feedback")
                        .text("Phone number must be exactly 10 digits.")
                        .show();
                    isValid = false;
                } else {
                    $("#phone").next(".invalid-feedback").hide();
                }

                if (!isValid) {
                    return; // Stop execution
                }

                // Proceed with form submission or AJAX logic
                const action = $(this).data("action");
                const url = window.location.href; // Replace with your API endpoint

                let myAction;
                if (action === "edit") {
                    $("#formId").val($("#formId").val());
                    myAction = "editContact";
                } else {
                    $("#formId").val("");
                    myAction = "addContact";
                }

                const formData = new FormData();

                formData.append("id", $("#formId").val());
                formData.append("firstName", $("#firstName").val());
                formData.append("lastName", $("#lastName").val());
                formData.append("gender", $("#gender").val());
                formData.append("email", $("#email").val());
                formData.append("phone", $("#phone").val());
                formData.append("address", $("#address").val());
                formData.append("city", $("#city").val());
                formData.append("state", $("#state").val());
                formData.append("zip", $("#zip").val());
                formData.append("country", $("#country").val());
                formData.append("action", myAction);

                const file = $("#imageInput")[0].files[0];
                if (file) {
                    formData.append("fileToUpload", file);
                }

                $.ajax({
                    url: url,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status === "success") {
                            alert(response.message); // Show the server's response
                            $(".needs-validation")[0].reset();
                            $("#exampleModal").modal("hide"); // Hide the modal
                            previewImage.src = "";
                            imagePreview.style.display = "none";
                            imageInput.value = ""; // Clear the file input // Clear form fields
                            loadTableData(); // Refresh the table (assuming this function exists)
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Parse the response message from the server
                        try {
                            const response = JSON.parse(xhr.responseText);
                            alert("Error: " + response.error); // Display the error message
                        } catch (e) {
                            alert("An error occurred, but the error message could not be retrieved.");
                        }

                        console.error("Error details:", xhr.responseText, status, error);
                    },
                });
            });

            //form modal scripts ends

        });
        //jquery scripts ends
    </script>