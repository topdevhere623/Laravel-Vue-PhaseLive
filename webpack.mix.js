let mix = require('laravel-mix');
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

if (!mix.inProduction()) {
    mix.webpackConfig({
        devtool: 'source-map'
    }).sourceMaps()
}
mix.webpackConfig({
        resolve: {
            alias: {
                styles: path.resolve(__dirname, './resources/assets/sass/'),
                store$: path.resolve(__dirname, 'resources/assets/js/vue/store/store.js'),
                events$: path.resolve(__dirname, 'resources/assets/js/vue/event-bus.js'),
                global: path.resolve(__dirname, 'resources/assets/js/vue/components/global/'),
            }
        }
    })
    .options(
        {
            processCssUrls: false,
            postCss: [
                require('lost')
            ],
        }
    )
    .js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/admin.js', 'public/js')
    .vue()
    .extract([
        'vue', 'axios', 'chart.js', 'epic-spinners', 'js-cookie', 'lodash', 'lost', 'moment', 'showdown',
        'vee-validate', 'vue-js-modal', 'vue-notification', 'vue-progressbar', 'vue-router', 'vuex'
    ])
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass_admin/admin.scss', 'public/css');


 
