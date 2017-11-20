const ExtractTextPlugin = require('extract-text-webpack-plugin')
const basePath = require('./resources/assets/build/helpers').basePath
const FriendlyErrorsWebpackPlugin = require('friendly-errors-webpack-plugin')

module.exports = {
  entry: [
    './resources/assets/js/app.js',
    './resources/assets/sass/app.sass'
  ],
  plugins: [
    new FriendlyErrorsWebpackPlugin(),
    new ExtractTextPlugin('css/app.css') // points to the output.publicPath path
  ],
  output: {
    path: basePath('public'),
    publicPath: '/public/',
    filename: 'js/app.js'
  },
  resolve: {
    extensions: ['.js', '.vue'],
    alias: {
      '@': basePath('resources/assets/js'),
      'vue$': 'vue/dist/vue.esm.js'
    }
  },
  module: {
    rules: [
      {
        test: /\.(js|vue)$/,
        loader: 'eslint-loader',
        enforce: 'pre',
        include: [basePath('resources/assets/js')],
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader',
        include: [basePath('resources/assets/js')],
        options: {
          loaders: {
            scss: 'vue-style-loader!css-loader!sass-loader',
            sass: 'vue-style-loader!css-loader!sass-loader?indentedSyntax'
          }
        }
      },
      {
        test: /\.js$/,
        loader: 'babel-loader',
        include: [basePath('resources/assets/js')]
      },
      {
        test: /\.sass$/,
        loader: ExtractTextPlugin.extract([
          { loader: 'css-loader', options: { minimize: true } },
          'sass-loader'
        ]),
        include: [basePath('resources/assets/sass')]
      }
    ]
  }
}
