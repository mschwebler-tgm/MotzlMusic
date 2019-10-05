const webpackConfig = {
    resolve: {
        alias: {
            '$components': path.resolve('resources/js'),
            '$scripts': path.resolve('resources/js'),
            '$store': path.resolve('resources/js/store/modules'),
        }
    }
};

module.exports = webpackConfig;
