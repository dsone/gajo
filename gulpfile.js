process.env.DISABLE_NOTIFIER = true;
const elixir = require('laravel-elixir');


elixir(function(mix) {
    mix.sass('app.scss')
        // SVG variant for FA5 in Laravel
        .copy('node_modules/@fortawesome/fontawesome-free/svgs', 'resources/assets/svg')

        .sass(
            [
                'bulma.sass',
                './node_modules/bulmaswatch/flatly/bulmaswatch.min.css'
            ],
            'public/vendor/bulma/bulma.min.css'
        )

        // Application
        .scripts([
            './node_modules/axios/dist/axios.js',
        ], 'public/vendor/axios/axios.min.js')
        .browserify('app.js')

        // add version information at end to prevent CF to cache and deliver outdated data
        .version([
            'public/vendor/bulma/bulma.min.css',
            'public/vendor/axios/axios.min.js',
            'css/app.css',
            'js/app.js',
        ], 'public');  // without 'public' elixir would createa a folder called build and put everything in there
});