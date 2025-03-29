document.addEventListener("DOMContentLoaded", () => {
    const successMessage = document.querySelector(".successMessage");

    if (successMessage) {
        setTimeout(() => {
            successMessage.style.display = "none";
        }, 9000);
    }
});
