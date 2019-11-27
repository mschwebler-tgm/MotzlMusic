const mix = require('laravel-mix');
const webpackConfig = require('./webpack.config');

mix.js('resources/js/app.js', 'public/js')
    .webpackConfig(webpackConfig);

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
        .babelConfig({
            plugins: ['@babel/plugin-syntax-dynamic-import'],
        })
        .version()
        .sourceMaps();
}
