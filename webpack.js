const path = require('path')
const webpackConfig = require('@nextcloud/webpack-vue-config')

const buildMode = process.env.NODE_ENV
const isDev = buildMode === 'development'
webpackConfig.devtool = isDev ? 'cheap-source-map' : 'source-map'

webpackConfig.stats = {
	colors: true,
	modules: false,
}

webpackConfig.entry = {
	adminSettings: {import: path.join(__dirname, 'src', 'adminSettings.js'), filename: 'htmlwidget-adminSettings.js'},
	dashboard: {import: path.join(__dirname, 'src', 'dashboard.js'), filename: 'htmlwidget-dashboard.js'},
}

module.exports = webpackConfig
