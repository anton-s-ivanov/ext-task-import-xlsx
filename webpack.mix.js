const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js');

// mix.options({
//     hmrOptions: {
//         host: 'localhost',
//         port: 8080
//     }
// })