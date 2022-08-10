const glob = require('glob');
const path = require('path');
const CopyPlugin = require('copy-webpack-plugin');

const entries = glob.sync('./progs/**/assets/js/index.js').reduce((acc, path) => {
    const entry = path.replace('./progs/', '').replace('/assets/js/index.js', '');
    acc[entry] = {
        dependOn: 'core',
        import: path
    };
    return acc;
}, {})
entries.core = './src/assets/js/index.js';

const copyPatterns = glob.sync("./progs/**/assets/img").map((path) => {
    return {
        from: path.replace('./', ''),
        to: "img/" + path.replace('./progs/', '').replace('/assets/img', '')
    }
});
copyPatterns.push({
    from: 'src/assets/img',
    to: 'img/core'
})

module.exports = {
    module: {
        rules: [
            {
                test: /\.css$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'style-loader'
                    },
                    {
                        loader: 'css-loader',
                        options: {
                            importLoaders: 1
                        }
                    },
                    {
                        loader: 'postcss-loader'
                    }
                ]
            }
        ]
    },
    entry: entries,
    output: {
        filename: './js/[name].[contenthash].js',
        path: path.resolve(__dirname, 'public/assets'),
        clean: true
    },
    plugins: [
        new CopyPlugin({
            patterns: copyPatterns,
        })
    ]
}