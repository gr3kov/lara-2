document.addEventListener("DOMContentLoaded", function () {
    const playbtns = document.querySelectorAll('.winner-card-video-playbtn');
    playbtns.forEach(playbtn => {
        playbtn.addEventListener("click", function(e) {
            e.target.classList.add('is-active');
            e.target.previousElementSibling.play();
            e.target.previousElementSibling.setAttribute("controls", true);
        });
    });
});
