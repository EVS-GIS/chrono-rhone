import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import store from './store'
import router from './router'
import Buefy from 'buefy'
import "./validation"

const BASE_URL = process.env.MIX_APP_URL || 'http://localhost:8000'

Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(Buefy)



window.axios = axios
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.baseURL = `${BASE_URL}/api/v1/`

const token = localStorage.getItem('token')
if (token) {
  axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
}
// Intercepteur de la requête pour rafraichir le token ou se déconnecter
axios.interceptors.response.use(
  function (response) {
    return response
  }, 
  function (error) {
    const originalRequest = error.config
    if (error.response.status === 401 && error.response.data.msg == "Token expired") {
      originalRequest._retry = true
      return axios.post('auth/refresh')
        .then(resp => {
          localStorage.setItem('token', resp.data.access_token)
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + resp.data.access_token
          originalRequest.headers['Authorization'] = 'Bearer ' + resp.data.access_token
          store.commit('AUTH_SUCCESS', resp)
          return axios(originalRequest)
        }).catch((error) => {
          store.dispatch('AUTH_LOGOUT').then(() => {
            router.push({ name: 'Login' })
          }).catch(() => {
            router.push({ name: 'Login' })
          })
        })
    }
    return Promise.reject(error)
})
