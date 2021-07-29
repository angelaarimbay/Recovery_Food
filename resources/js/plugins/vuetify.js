
import '@mdi/font/css/materialdesignicons.css' // Ensure you are using css-loader 
import Vue from 'vue';
import Vuetify from 'vuetify/lib';
 
Vue.use(Vuetify);
 
export default new Vuetify({ 
  iconfont: 'mdi', 
  theme: {
    themes: {
      light: {
        primary: '#00794b',
        danger: '#CC0022',
        secondary: '#75757C', 
      },
    },
  },
});