const webpack = require('webpack')
const merge = require('webpack-merge')
const config = require('../../../webpack.config')
const Uglify = require('uglifyjs-webpack-plugin')

config.plugins.push(
  new Uglify(),
  new webpack.DefinePlugin({
    'process.env': {
      NODE_ENV: '"production"'
    }
  })
)

webpack(config, () => {})
