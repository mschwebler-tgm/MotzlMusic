process.env.APP_ENV = 'testing';

const webpackConf = require('./node_modules/laravel-mix/setup/webpack.config.js');
delete webpackConf.entry;

module.exports = function(config) {
    config.set({
        basePath: './resources/js/tests/',
        frameworks: ['jasmine'],
        files: [
            { pattern: '*.spec.js', watched: false }
        ],
        exclude: [],

        webpack: webpackConf,
        // webpackMiddleware: {
        //     noInfo: true,
        //     stats: 'errors-only'
        // },
        preprocessors: {
            'app.js': ['webpack'],
            '*.spec.js': ['webpack']
        },

        reporters: ['progress'],
        port: 9876,
        colors: true,
        logLevel: config.LOG_INFO,
        autoWatch: true,
        browsers: ['ChromeHeadless'],
        singleRun: false,
        concurrency: Infinity
    })
};
