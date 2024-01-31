document.addEventListener("DOMContentLoaded", function () {
    const spoilers = document.querySelectorAll('.faq-item-spoiler');
    spoilers.forEach(element => {
        element.addEventListener("click", function (e) {
            e.target.classList.toggle('is-active');
            e.target.parentElement.parentElement.classList.toggle('is-active');
        });
    });
});
