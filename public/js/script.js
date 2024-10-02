document.addEventListener("DOMContentLoaded", () => {
    const successMessage = document.querySelector(".successMessage");

    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = "none";
        }, 2000);
    }

    const errorMessage = document.querySelector(".errorMessage");

    if (successMessage) {
        setTimeout(() => {
            errorMessage.style.display = "none";
        }, 2000);
    }
});
