document.addEventListener('DOMContentLoaded', function () {
    document.querySelector('.row1__col4-spoiler').addEventListener('click', function (e) {
        if (e.target.classList.contains('is-active')) {
            e.target.classList.remove('is-active');
            e.target.textContent = 'Развернуть';
            document.querySelector('.row1__col4').classList.remove('is-active');
        } else {
            e.target.classList.add('is-active');
            e.target.textContent = 'Свернуть';
            document.querySelector('.row1__col4').classList.add('is-active');
        }
    })
});
