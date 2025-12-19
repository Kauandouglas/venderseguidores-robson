const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    // Web
    .sass('resources/views/web/assets/scss/style.scss', 'public/web_assets/css')
    .scripts([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/@popperjs/core/dist/umd/popper.js',
        'node_modules/bootstrap/dist/js/bootstrap.js',
        'node_modules/aos/dist/aos.js',
        'node_modules/jquery-mask-plugin/dist/jquery.mask.js',
        'node_modules/jquery.flipster/dist/jquery.flipster.min.js',
        'node_modules/sweetalert2/dist/sweetalert2.all.js',
        'resources/views/web/assets/js/template.js'
    ], 'public/web_assets/js/scripts.js')
    .copyDirectory('resources/views/web/assets/images', 'public/web_assets/images')

    // Panel
    .sass('resources/views/panel/assets/scss/app.scss', 'public/panel_assets/css')
    .scripts([
        'node_modules/jquery/dist/jquery.js',
        'resources/views/panel/assets/js/feather.min.js',
        'resources/views/panel/assets/js/jquery-ui.js',
        'node_modules/perfect-scrollbar/dist/perfect-scrollbar.js',
        'node_modules/jquery-mask-plugin/dist/jquery.mask.js',
        'node_modules/apexcharts/dist/apexcharts.js',
        'node_modules/sweetalert2/dist/sweetalert2.all.js',
        'resources/views/panel/assets/js/app.js',
        'resources/views/panel/assets/js/main.js',
    ], 'public/panel_assets/js/scripts.js')
    .copyDirectory('resources/views/panel/assets/images', 'public/panel_assets/images')

    // Templates
    .styles([
        'resources/views/templates/zinc/assets/css/bootstrap.min.css',
        'resources/views/templates/zinc/assets/css/fontawesome-all.min.css',
        'resources/views/templates/zinc/assets/css/swiper.css',
        'resources/views/templates/zinc/assets/css/styles.css'
    ], 'public/template_assets/zinc/css/style.css')
    .scripts([
        'node_modules/jquery/dist/jquery.js',
        'resources/views/templates/zinc/assets/js/bootstrap.min.js',
        'resources/views/templates/zinc/assets/js/swiper.min.js',
        'resources/views/templates/zinc/assets/js/purecounter.min.js',
        'resources/views/templates/zinc/assets/js/isotope.pkgd.min.js',
        'resources/views/templates/zinc/assets/js/scripts.js',
    ], 'public/template_assets/zinc/js/scripts.js')
    .copyDirectory('resources/views/templates/zinc/assets/images', 'public/template_assets/zinc/images')
    .copyDirectory('resources/views/templates/zinc/assets/fonts', 'public/template_assets/zinc/fonts')
    .copyDirectory('resources/views/templates/zinc/assets/webfonts', 'public/template_assets/zinc/webfonts')

    .version()
    .disableNotifications()
