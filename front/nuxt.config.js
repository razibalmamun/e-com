export default {
  // Disable server-side rendering: https://go.nuxtjs.dev/ssr-mode
  ssr: false,

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'Frontend',
    htmlAttrs: {
      lang: 'en'
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' }
    ],
    link: [
      { rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }
    ]
  },
  loading: { color: "#3adced" },
  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [
    "~assets/css/app"
  ],
  publicRuntimeConfig: {
      remoteBaseUrl: process.env.REMOTE_BASE_URL || 'http://127.0.0.1:8000',
  },
  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [
    '~/plugins/common.js',
    '~/plugins/axios.js',
    { src: '~/plugins/external-packages.js', mode: 'client' },
    '~/plugins/vidle.js',
    '~/plugins/i18n.js',
  ],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/tailwindcss
    '@nuxtjs/tailwindcss',
  ],

  router: {
      middleware: ['auth']
  },

  axios: {
      credentials: true
  },

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    '@nuxtjs/axios',
    'nuxt-i18n',
    '@nuxtjs/toast',
    '@nuxtjs/auth-next',
    ['vue-scrollto/nuxt', { duration: 300 }],
  ],

  i18n: {
      locales: [
          {
              name: 'English',
              code: 'en',
              iso: 'en-US',
              flag: 'gb.png',
              file: 'en.js'
          },
          {
              name: 'Italiano',
              code: 'it',
              iso: 'it-IT',
              flag: 'it.png',
              file: 'it.js'
          }
      ],
      lazy: true,
      langDir: 'lang/',
      defaultLocale: 'en',
      detectBrowserLanguage: {
          useCookie: false,
          cookieKey: 'i18n_redirected',
          onlyOnRoot: true,  // recommended
          cookieCrossOrigin: true
      }
  },
  toast: {
      position: 'top-center',
      duration: 2000
  },
  auth: {
      redirect: {
          login: '/auth/login',
          logout: '/auth/login',
          callback: '/auth/login',
          home: '/admin/'
      },
      fullPathRedirect: true,
      strategies: {
          local: {
              token: {
                  property: 'token',
                  required: true,
                  type: 'Bearer',
                  maxAge: 86400, //24 hrs
                  global: true
              },
              user: {
                  property: 'user',
                  autoFetch: true
              },
              endpoints: {
                  login: { url: '/v1/auth/login', method: 'post' },
                  logout: { url: '/v1/auth/logout', method: 'post' },
                  user: { url: '/v1/auth/me', method: 'get' }
              }
          }
      },
      plugins: ['~/plugins/auth.js']
  },

  server: {
      port: process.env.PORT || 3000
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {
  }
}
