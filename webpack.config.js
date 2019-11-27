const webpackConfig = {
    output: {
        chunkFilename: 'js/chunks/[name].js',
    },
    optimization: {
        splitChunks: {
            // include all types of chunks
            chunks: 'all',
            name: 'vendors',
        }
    },
    resolve: {
        alias: {
            '$components': path.resolve('resources/js'),
            '$scripts': path.resolve('resources/js'),
            '$store': path.resolve('resources/js/store/modules'),
        }
    },
};

module.exports = webpackConfig;
