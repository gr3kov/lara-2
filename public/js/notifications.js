document.addEventListener("DOMContentLoaded", function () {
    const spoilers = document.querySelectorAll('.notifications-card-spoiler');
    spoilers.forEach(element => {
        element.addEventListener("click", function (e) {
            e.target.classList.toggle('is-active');
            e.target.parentElement.querySelector('.notifications-card-content').classList.toggle('is-active');
        });
    });
});
