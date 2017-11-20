const webpack = require('webpack')
const merge = require('webpack-merge')
const config = require('../../../webpack.config')

config.plugins.push(
  new webpack.DefinePlugin({
    'process.env': {
      NODE_ENV: '"development"'
    }
  })
)

const compiler = webpack(merge(config, {
  watch: true,
}), () => {})
