let Encore         = require('@symfony/webpack-encore');
let webpack        = require('webpack');
let UglifyJsPlugin = require('uglifyjs-webpack-plugin');

Encore
    .setOutputPath('public/assets/')
    .setPublicPath('/assets')
    .cleanupOutputBeforeBuild()
    .addEntry('js/main', './assets/js/main.js')
    .addStyleEntry('css/main', './assets/css/main.scss')
    .enableSassLoader()
    .autoProvidejQuery()
    .enableSourceMaps(!Encore.isProduction())

    .addLoader({
        test: /\.html$/,
        loader: 'html-loader',
    })
;

let config = Encore.getWebpackConfig();

if (Encore.isProduction()) {

    config.plugins = config.plugins.filter(function (plugin) {
        return !(plugin instanceof webpack.optimize.UglifyJsPlugin);
    });

    Encore
        .addPlugin(new UglifyJsPlugin({
            parallel: true,
            uglifyOptions: {
                ie8: false,
                ecma: 8,
                warnings: true,
            },
        }));
}

module.exports = config;
