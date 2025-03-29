document.addEventListener("DOMContentLoaded", () => {
    const errorMessage = document.querySelector(".errorMessageWithTimer");

    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.display = "none";
        }, 9000);
    }
});
