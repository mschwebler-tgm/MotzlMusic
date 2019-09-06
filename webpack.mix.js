const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .webpackConfig({
        resolve: {
            alias: {
                '$components': path.resolve('resources/js'),
                '$store': path.resolve('resources/js/store/modules'),
            }
        }
    });

if (process.env.APP_ENV !== 'testing') {
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
        })
        .version()
        .sourceMaps();
}
