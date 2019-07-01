import VueRouter from 'vue-router';
import router from './router';
import store from './store/store';

import 'clusterize.js';
import 'vuetify/dist/vuetify.min.css'; // Ensure you are using css-loader

import Vue from 'vue';
import Vuetify from 'vuetify'
import theme from './theme';
import {setSystemBarColor} from './theme';
import MainContentHeaders from './components/Layout/MainContentHeader/MainContentHeaders';

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
            mainContentHeaderComponent: MainContentHeaders.DEFAULT,
            user: null,
            isTouch: false,
            snackbar: {
                show: false,
                text: '',
            }
        }
    },
    created() {
        this.detectTouch();
        setSystemBarColor('accent');
    },
    methods: {
        detectTouch() {
            try {
                document.createEvent("TouchEvent");
                this.isTouch = true;
            } catch (error) {
                this.isTouch = false;
            }
        },
        getSpotifyImage(playlist, minResolution = 'large') {
            let imageToReturn = null;
            const indexByResolution = {'small': 0, 'medium': 1, 'large': 2};
            const images = [
                playlist.spotify_image_small,
                playlist.spotify_image_medium,
                playlist.spotify_image_large,
            ];
            images.forEach((image, index) => {
                if (index >= indexByResolution[minResolution]) {
                    imageToReturn = image;
                }
            });

            return imageToReturn || window.playlistFallback;
        },
        showAlert(text) {
            this.snackbar.text = text;
            this.snackbar.show = true;
        }
    },
    watch: {
        isDarkTheme(isDark) {
            localStorage.setItem('useDarkTheme', 0 + isDark);
        }
    }
});

export default app;