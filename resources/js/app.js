import VueRouter from 'vue-router';
import router from './router';
import store from './store/store';

import 'clusterize.js'
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader

import Vue from 'vue';
import Vuetify from 'vuetify'

Vue.use(Vuetify);
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
