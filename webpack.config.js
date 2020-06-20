const webpack = require('webpack');
const path = require('path');
const package = require('./package.json');
const VueLoaderPlugin = require('vue-loader/lib/plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const TerserJSPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require('optimize-css-assets-webpack-plugin');
// const config = require( './config.json' );

const devMode = process.env.NODE_ENV !== 'production';

// Naming and path settings
var appName = 'wpb';
var entryPoint = {
  frontend: './resources/js/frontend/main.js',
  admin: './resources/js/admin/main.js',
  spa: './resources/js/spa/main.js',
  style: './resources/sass/app.scss'
};

var exportPath = path.resolve(__dirname, './public/js');

// Enviroment flag
var plugins = [];
var env = process.env.NODE_ENV;

function isProduction() {
  return process.env.NODE_ENV === 'production';
}

// extract css into its own file
plugins.push(new MiniCssExtractPlugin({
  filename: '../css/[name].css',
  ignoreOrder: false, // Enable to remove warnings about conflicting order
}));

// plugins.push(new BrowserSyncPlugin( {
//   proxy: {
//     target: config.proxyURL
//   },
//   files: [
//     '**/*.php'
//   ],
//   cors: true,
//   reloadDelay: 0
// } ));

plugins.push(new VueLoaderPlugin());

// Differ settings based on production flag
if ( devMode ) {
  appName = '[name].js';
} else {
  appName = '[name].min.js';
}

module.exports = {
  entry: entryPoint,
  mode: devMode ? 'development' : 'production',
  output: {
    path: exportPath,
    filename: appName,
  },

  resolve: {
    alias: {
      'vue$': 'vue/dist/vue.esm.js',
      '@': path.resolve('./resources/'),
      'frontend': path.resolve('./resources/frontend/'),
      'admin': path.resolve('./resources/admin/'),
      'spa': path.resolve('./resources/spa/'),
    },
    modules: [
      path.resolve('./node_modules'),
      path.resolve(path.join(__dirname, 'resources/')),
    ]
  },

  optimization: {
    runtimeChunk: 'single',
    splitChunks: {
      cacheGroups: {
        vendor: {
          test: /[\\\/]node_modules[\\\/]/,
          name: 'vendors',
          chunks: 'all'
        }
      }
    },
    minimizer: [new TerserJSPlugin({}), new OptimizeCSSAssetsPlugin({})],
  },

  plugins,

  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: 'vue-loader'
      },
      {
        test: /\.js$/,
        use: 'babel-loader',
        exclude: /node_modules/
      },
      {
        test: /\.scss$/,
        use: [
          'vue-style-loader',
          'css-loader',
          'sass-loader'
        ]
      },
      {
        test: /\.less$/,
        use: [
          'vue-style-loader',
          'css-loader',
          'less-loader'
        ]
      },
      {
        test: /\.png$/,
        use: [
          {
            loader: 'url-loader',
            options: {
              mimetype: 'image/png'
            }
          }
        ]
      },
      {
        test: /\.svg$/,
        use: 'file-loader'
      },
      {
        test: /\.css$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: {
              publicPath: (resourcePath, context) => {
                return path.relative(path.dirname(resourcePath), context) + '/';
              },
              hmr: process.env.NODE_ENV === 'development',
            },
          },
          'css-loader',
        ],
      },
    ]
  },
}