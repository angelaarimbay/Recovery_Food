// src/plugins/vuetify.js

import Vue from 'vue'
import Vuetify from 'vuetify/lib'
import 'vuetify/dist/vuetify.min.css'


Vue.use(Vuetify)
 

export default new Vuetify( {
    theme: {
        themes: {
            light: {
                primary: '#00794b',
                danger: '#CC0022',
                secondary: '#005cb0',
            },
        }
    }
}
)
