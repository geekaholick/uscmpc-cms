import Vue from 'vue'
import Vuex from 'vuex'
import CreatePersistedState from 'vuex-persistedstate'

// Modules
import app from './app'
import appConfig from './app-config'
import verticalMenu from './vertical-menu'
import consumerStore from './modules/consumer_store'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    app,
    appConfig,
    verticalMenu,
    consumerStore,
  },
  strict: process.env.DEV,
  plugins: [CreatePersistedState()],
})
