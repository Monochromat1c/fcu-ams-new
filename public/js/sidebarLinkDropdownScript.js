document.addEventListener("DOMContentLoaded", function () {
    // Get the current URL
    var currentUrl = window.location.href;
    // Get all dropdown buttons
    var dropdownButtons = document.querySelectorAll(".relative button");
    // Loop through each dropdown button
    dropdownButtons.forEach(function (button) {
        // Get the dropdown links
        var dropdownLinks = button.nextElementSibling.querySelectorAll("a");
        // Loop through each dropdown link
        dropdownLinks.forEach(function (link) {
            // Check if the current URL matches or starts with the link's href
            if (currentUrl === link.href || currentUrl.startsWith(link.href)) {
                // Open the dropdown
                button.click();
            }
        });
    });
});