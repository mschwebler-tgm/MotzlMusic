const Visualizer = require('webpack-visualizer-plugin');

const plugins = [];
if (process.env.NODE_ENV !== 'production') {
    plugins.push(new Visualizer({
        filename: './statistics.html'
    }));
}

const webpackConfig = {
    resolve: {
        alias: {
            '$components': path.resolve('resources/js'),
            '$scripts': path.resolve('resources/js'),
            '$store': path.resolve('resources/js/store/modules'),
        }
    },
    plugins,
};

module.exports = webpackConfig;
