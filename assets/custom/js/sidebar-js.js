$(document).ready(function() {
    // Get the current URL path
    var currentPath = window.location.pathname;

    // Loop through all <a> tags in the menu and check their href
    $(".sidebar-menu .menu-links a").each(function() {
        if ($(this).attr("href") === currentPath) {
            // Add active class to the parent <li> if href matches the current path
            $(this).parent("li").addClass("active");
        }
    });
});