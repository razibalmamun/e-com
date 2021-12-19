module.exports = {
    apps: [
      {
        name: 'front',
        exec_mode: 'cluster',
        instances: '1', // max Or a number of instances
        script: './node_modules/nuxt/bin/nuxt.js',
        args: 'start'
      }
    ]
  }