document.addEventListener("DOMContentLoaded", function () {
    var successMessage = document.querySelector(".successMessage");

    if (successMessage) {
        setTimeout(function () {
            successMessage.style.display = "none";
        }, 3000);
    }
});
