import VueRouter from 'vue-router';
import router from './router';
import store from './store/store';

import 'clusterize.js'
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader

import Vue from 'vue';
import Vuetify from 'vuetify'
// Helpers
import colors from 'vuetify/es5/util/colors';

Vue.use(VueRouter);
Vue.use(Vuetify, {
    theme: {
        info: colors.blue.lighten2,
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
        }
    },
    watch: {
        isDarkTheme(isDark) {
            localStorage.setItem('useDarkTheme', 0 + isDark);
        }
    }
});
