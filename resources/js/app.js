import VueRouter from 'vue-router';
import router from './router';
import Buefy from 'buefy';
// import 'buefy/src/scss/buefy.scss';

import store from './store/store';

window.Vue = require('vue');

Vue.component('gauss', require('./components/Ideas/Gauss/Gauss.vue'));
Vue.component('gauss-wrapper', require('./components/Ideas/Gauss/GaussWrapper.vue'));

Vue.use(VueRouter);
Vue.use(Buefy);

const app = new Vue({
    el: '#root',
    router,
    store,
    data() {
        return {
            showSpotifyImport: false
        }
    }
  });
