module.exports = {
    transpileDependencies: [], 
      // proxy API requests to Valet during development
    devServer: {
          //proxy: 'http://localhost:8000'//с пушером траблы вызывает;
          proxy: {
              '^/api': {
                target: 'https://areal-gdrive.com/api/v1/', //проксировать все api-запросы к ларавелу
                ws: true,
                changeOrigin: true
              }
            }
    },
    outputDir: '../backend/public',
    indexPath: process.env.NODE_ENV === 'production' ?
                  '../resources/views/index.blade.php'
                  : 'index.html'
}