<script>
    const APP_URI = window.location.pathname;

    switch (APP_URI) {
        case '/adminlte_practice01/login.php':
            $(document).ready(function() {

                'use strict';

                // Fetch all forms with the "needs-validation" class
                $('.needs-validation').each(function() {
                    const form = $(this);

                    // Add event listener for the form's submission
                    form.on('submit', function(event) {
                        // Trigger validation only after the submit button is clicked
                        const isValid = validateForm(form);

                        // Prevent form submission if validation fails
                        if (!isValid) {
                            event.preventDefault();
                            event.stopPropagation();
                        }

                        // Add Bootstrap validation styling class
                        form.addClass('was-validated');
                    });
                });

                // Function to validate form inputs
                function validateForm(form) {
                    let isValid = true;

                    form.find('input, textarea, select').each(function() {
                        const input = $(this);
                        const formGroup = input.closest('.form-group');

                        if (input[0].checkValidity()) {
                            // Mark as valid
                            formGroup.addClass('has-success').removeClass('has-error');
                            formGroup.find('.help-block').remove(); // Remove error messages
                        } else {
                            // Mark as invalid
                            formGroup.addClass('has-error').removeClass('has-success');
                            if (formGroup.find('.help-block').length === 0) {
                                // Append error message
                                formGroup.append(`<span class="help-block">${input[0].validationMessage}</span>`);
                            }
                            isValid = false; // Mark form as invalid
                        }
                    });

                    return isValid; // Return the overall validity of the form
                }

                $('#myForm').submit(function(e) {
                    e.preventDefault(); // Prevent default form submission

                    // Gather form data
                    var formData = $(this).serialize(); // Serializes the form's elements
                    $.ajax({
                        url: window.location.href, // Replace with your server endpoint
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response) {
                            if (response.status === 'success') {
                                // Login successful - Redirect to another page
                                window.location.href = "/adminlte_practice01/"; // Replace with your target page
                            } else if (response.status === 'error') {
                                // Display error message
                                $('#errorMessage').text(response.message).show();
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error response
                            alert('An error occurred: ' + error);
                            console.error(xhr.responseText);
                        }
                    });
                });
            });
            break;
        case '/adminlte_practice01/contact-list.php':
            // jquery scripts starts
            $(document).ready(function() {

                //sidebar scripts starts
                // Get the current URL path
                var currentPath = window.location.href;

                // Loop through all <a> tags in the menu and check their href
                $(".sidebar-menu .menu-links a").each(function() {
                    if ($(this).attr("href") === currentPath) {
                        // Add active class to the parent <li> if href matches the current path
                        $(this).parent("li").addClass("active");
                    }
                });
                //sidebar scripts ends

                //contact-list scripts starts
                // Load table data using AJAX
                function loadTableData() {
                    $.ajax({
                        url: window.location.href, // Path to your PHP script
                        method: "POST",
                        data: {
                            action: "readContacts",
                        },
                        dataType: "json",
                        success: function(data) {
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
                                alert("Data deleted successfully: " + response);
                                button.closest("tr").remove(); // Remove the row from the table
                                loadTableData(); // Refresh the table
                            },
                            error: function(xhr, status, error) {
                                alert("An error occurred: " + error);
                            },
                        });
                    }
                });
                //contact-list scripts ends

                //form modal scripts starts
                "use strict";
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
                    $("#email").val(rowData.email);
                    $("#phone").val(rowData.phone);
                    $("#address").val(rowData.address);
                    $("#city").val(rowData.city);
                    $("#state").val(rowData.state);
                    $("#zip").val(rowData.zip);
                    $("#country").val(rowData.country);

                    // Handle the image preview
                    if (rowData.imagePath) {
                        $("#previewImage").attr("src", rowData.imagePath).show(); // Show existing image
                        $("#removeButton").show(); // Show the remove button
                    } else {
                        $("#previewImage").hide();
                        $("#removeButton").hide();
                    }

                    $("#exampleModal").modal("show"); // Show the modal
                });
                // Remove image button functionality
                $(document).on("click", "#removeButton", function() {
                    $("#previewImage").hide().attr("src", ""); // Clear the preview image
                    $("#imageInput").val(""); // Clear the input field
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
                        // If phone number is invalid
                        $("#phone")
                            .closest(".form-group")
                            .addClass("has-error")
                            .removeClass("has-success");
                        $("#phone")
                            .next(".invalid-feedback")
                            .text("Phone number must be exactly 10 digits.")
                            .show();
                        isValid = false;
                    } else {
                        // If phone number is valid
                        $("#phone")
                            .closest(".form-group")
                            .addClass("has-success")
                            .removeClass("has-error");
                        $("#phone").next(".invalid-feedback").hide();
                    }

                    if (!isValid) {
                        form.classList.add("was-validated"); // Trigger feedback for invalid form
                        return; // Stop execution
                    }

                    // Proceed with form submission or AJAX logic
                    const action = $(this).data("action");
                    const url =
                        action === "add" ?
                        window.location.href :
                        window.location.href;

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
                            alert(response); // Show the server's response
                            $(".needs-validation")[0].reset();
                            $("#exampleModal").modal("hide"); // Hide the modal
                            previewImage.src = "";
                            imagePreview.style.display = "none";
                            imageInput.value = ""; // Clear the file input // Clear form fields
                            loadTableData(); // Refresh the table (assuming this function exists)
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
                //form modal scripts ends

                //logout scripts starts
                $('#logout').click(function() {
                    $.ajax({
                        url: window.location.href,
                        method: 'POST',
                        data: {
                            action: 'logout'
                        },
                        success: function(response) {
                            window.location.href = 'login.php';
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                });
                //logout scripts ends
            });
            //jquery scripts ends
            break;
        default:

            //jquery scripts starts
            $(document).ready(function () {
                //dashboard ajax scripts starts
                $.ajax({
                    url: window.location.href, // Replace with your API endpoint
                    method: 'POST', // You can change this to POST if needed
                    dataType: 'json',
                    data: {
                        action: "readContacts"
                    },
                    success: function(response) {
                        // Check if the response is an array
                        if (Array.isArray(response)) {
                            let rowCount = response.length; // Get the number of rows
                            console.log('Number of rows:', rowCount);
                            document.getElementById('contact-num').innerHTML = rowCount;
                        } else {
                            console.log('The response is not an array.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', status, error);
                    }
                });
                //dashboard ajax scripts ends
            });
            //jquery scripts ends

            //pie chart scripts starts
            $(function() {
                //-------------
                //- PIE CHART -
                //-------------
                // Get context with jQuery - using jQuery's .get() method.
                var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
                var pieChart = new Chart(pieChartCanvas);
                var PieData = [{
                        value: <?php echo genderCount("male"); ?>,
                        color: "#00a65a",
                        highlight: "#00a65a",
                        label: "Male"
                    },
                    {
                        value: <?php echo genderCount("female"); ?>,
                        color: "#f56954",
                        highlight: "#f56954",
                        label: "Female"
                    }
                ];
                var pieOptions = {
                    //Boolean - Whether we should show a stroke on each segment
                    segmentShowStroke: true,
                    //String - The colour of each segment stroke
                    segmentStrokeColor: "#fff",
                    //Number - The width of each segment stroke
                    segmentStrokeWidth: 2,
                    //Number - The percentage of the chart that we cut out of the middle
                    percentageInnerCutout: 50, // This is 0 for Pie charts
                    //Number - Amount of animation steps
                    animationSteps: 100,
                    //String - Animation easing effect
                    animationEasing: "easeOutBounce",
                    //Boolean - Whether we animate the rotation of the Doughnut
                    animateRotate: true,
                    //Boolean - Whether we animate scaling the Doughnut from the centre
                    animateScale: false,
                    //Boolean - whether to make the chart responsive to window resizing
                    responsive: true,
                    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                    maintainAspectRatio: true,
                    //String - A legend template
                    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
                };
                //Create pie or douhnut chart
                // You can switch between pie and douhnut using the method below.
                pieChart.Doughnut(PieData, pieOptions);
            });
            //pie chart scripts ends
            break;
    }
</script>