import { resolve } from 'path';

export default {
    entry: './src/index.js',
    output: {
        path: resolve('dist'),
        filename: 'bundle.js'
    }
};