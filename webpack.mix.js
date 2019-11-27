const mix = require('laravel-mix');
const webpackConfig = require('./webpack.config');
const Visualizer = require('webpack-visualizer-plugin');

const isProduction = process.env.NODE_ENV === 'production';
const isTesting = process.env.APP_ENV === 'testing';

mix.js('resources/js/app.js', 'public/js')
    .webpackConfig(webpackConfig);

if (!isTesting) {
    mix.sass('resources/sass/app.scss', 'public/css')
        .browserSync({
            files: [
                './resources/**/*',
            ],
            proxy: 'mm.local',
        })
        .webpackConfig({
            module: {
                rules: [
                    {
                        test: /\.jsx?$/,
                        exclude: /node_modules(?!\/foundation-sites)|bower_components/,
                        use: [
                            {
                                loader: 'babel-loader',
                                options: Config.babel(),
                            }
                        ]
                    }
                ]
            },
            plugins: getPlugins(),
        })
        .babelConfig({
            plugins: ['@babel/plugin-syntax-dynamic-import'],
        })
        .version()
}

if (!isProduction) {
    mix.sourceMaps();
}

function getPlugins() {
    const plugins = [];
    if (!isProduction) {
        plugins.push(new Visualizer({
            filename: './statistics.html'
        }));
    }

    return plugins;
}
