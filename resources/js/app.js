import './bootstrap'

import Vue from 'vue'
import App from './App.vue'
import store from './store'
import router from './router'
import VueI18n from 'vue-i18n'
import messages from './lang'
import { configure } from 'vee-validate'

Vue.config.productionTip = false
/* eslint-disable no-new */

Vue.use(VueI18n)
const i18n = new VueI18n({
  fallbackLocale: 'fr',
  locale: 'fr',
  messages
})

configure({
  defaultMessage: (field, values) => {
    values._field_ = i18n.t(`fields.${field}`)
    return i18n.t(`validations.${values._rule_}`, values)
  }
})

new Vue({
  el: '#app',
  i18n,
  router,
  store,
  components: { App },
  template: '<app/>'
})
