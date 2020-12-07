import Vue from 'vue'
import Vuex from 'vuex'
import auth from './auth'
import screen from './screen'
import filters from './filters'
import data from './data'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    auth,
    screen,
    filters,
    data
  }
})