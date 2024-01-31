const mix = require('laravel-mix');

mix
    .sass('resources/sass/app.scss', 'public/css')  // Путь к вашему исходному файлу стилей
    .minify('public/css/style.min.css');                 // Путь к минифицированному файлу
