const mix = require('laravel-mix');

const VuetifyLoaderPlugin = require('vuetify-loader/lib/plugin')
const CaseSensitivePathsPlugin = require('case-sensitive-paths-webpack-plugin');

var webpackConfig = {
    plugins: [
        new CaseSensitivePathsPlugin(),
        new VuetifyLoaderPlugin()
    ]
}

mix.webpackConfig(webpackConfig)

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');
