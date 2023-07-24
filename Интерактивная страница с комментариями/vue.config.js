const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
  devServer: { //здесь установил прокси для перенаправления на php (OpenServer)
    proxy: 'http://comments/'
  }
})
