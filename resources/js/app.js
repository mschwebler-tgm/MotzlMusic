import VueRouter from 'vue-router';
import router from './router';

import 'clusterize.js'
// import 'buefy/src/scss/buefy.scss';

import store from './store/store';

window.Vue = require('vue');

Vue.use(VueRouter);

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
