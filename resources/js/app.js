  

// window.Vue = require('vue');
 
import 'vuetify/dist/vuetify.min.css'
import Vue from 'vue';
import store from '~/store' 
import router from '~/router'
import i18n from '~/plugins/i18n' 
import vuetify from '~/plugins/vuetify' 
import App from '~/components/App'
import Vuetify from 'vuetify'

import '~/plugins'
import '~/components'
window.moment = require('moment');
window.numeral = require('numeral'); 
  
Vue.use(Vuetify)
new Vue({
    el: '#app',
    vuetify,
    // i18n,
    store,
    router,
    ...App
  })
 