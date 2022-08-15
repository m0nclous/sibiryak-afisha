import { resolve } from 'path';
import webpack from 'webpack';

export default {
    entry: './src/public/index.js',
    output: {
        path: resolve('dist'),
        filename: 'public-bundle.js'
    },

    plugins: [
        new webpack.DefinePlugin({
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: false
        })
    ],

    watchOptions: {
        aggregateTimeout: 600,
        poll: 1000
    }
};