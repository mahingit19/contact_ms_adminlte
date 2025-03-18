$(document).ready(function () {

    // Get the current URL path
    var currentPath = window.location.href;

    // Loop through all <a> tags in the menu and check their href
    $(".sidebar-menu .menu-links a").each(function () {
        if ($(this).attr("href") === currentPath) {
            // Add active class to the parent <li> if href matches the current path
            $(this).parent("li").addClass("active");
        }
    });

    //logout scripts starts
    $('#logout').click(function () {
        $.ajax({
            url: window.location.href,
            method: 'POST',
            data: {
                action: 'logout'
            },
            success: function (response) {
                window.location.href = 'login.php';
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
            }
        });
    });
    //logout scripts ends

});