// Assuming you have jQuery loaded in your project
$(document).ready(function () {
    
    'use strict';

    // Fetch all forms with the "needs-validation" class
    $('.needs-validation').each(function () {
        const form = $(this);

        // Add event listener for the form's submission
        form.on('submit', function (event) {
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

        form.find('input, textarea, select').each(function () {
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

    $('#myForm').submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        // Gather form data
        var formData = $(this).serialize(); // Serializes the form's elements
        const app_uri = "/adminlte_practice01/"; // Replace with your app URL
        $.ajax({
            url: app_uri + 'includes/functions.php', // Replace with your server endpoint
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    // Login successful - Redirect to another page
                    window.location.href = app_uri; // Replace with your target page
                } else if (response.status === 'error') {
                    // Display error message
                    $('#errorMessage').text(response.message).show();
                }
            },
            error: function (xhr, status, error) {
                // Handle error response
                alert('An error occurred: ' + error);
                console.error(xhr.responseText);
            }
        });
    });
});