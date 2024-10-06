document.addEventListener("DOMContentLoaded", () => {
    const errorMessage = document.querySelector(".errorMessage");

    if (errorMessage) {
        setTimeout(() => {
            errorMessage.style.display = "none";
        }, 2000);
    }
});
