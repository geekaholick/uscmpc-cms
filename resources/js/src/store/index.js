import Vue from 'vue'
import Vuex from 'vuex'
import CreatePersistedState from 'vuex-persistedstate'


// Modules
import app from './app'
import appConfig from './app-config'
import verticalMenu from './vertical-menu'
import investment from './modules/investment'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    app,
    appConfig,
    verticalMenu,
    investment,
  },
  plugins: [CreatePersistedState()],
  strict: process.env.DEV,
})
