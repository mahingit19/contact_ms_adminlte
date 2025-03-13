$(document).ready(function() {
    $.ajax({
        url: '/adminlte_practice01/includes/functions.php', // Replace with your API endpoint
        method: 'GET', // You can change this to POST if needed
        dataType: 'json',
        data: {
            action: "readContacts",
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
});