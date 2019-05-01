import VueRouter from 'vue-router';
import router from './router';
import store from './store/store';

import 'clusterize.js';
import 'vuetify/dist/vuetify.min.css'; // Ensure you are using css-loader

import Vue from 'vue';
import Vuetify from 'vuetify'
import theme from './theme';

Vue.component('auth-login', require('./components/Auth/Login').default);
Vue.component('auth-register', require('./components/Auth/Register').default);

Vue.use(VueRouter);
Vue.use(Vuetify, {
    theme,
    options: {
        customProperties: true,  // generate css variables
    }
});

const app = new Vue({
    el: '#root',
    router,
    store,
    data() {
        return {
            showSpotifyImport: false,
            isDarkTheme: localStorage.getItem('useDarkTheme') === '1',
            statusInfoComponent: null,
        }
    },
    watch: {
        isDarkTheme(isDark) {
            localStorage.setItem('useDarkTheme', 0 + isDark);
        }
    }
});

export default app;