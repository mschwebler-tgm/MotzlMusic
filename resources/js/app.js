import VueRouter from 'vue-router';
import router from './router';
import store from './store/store';

import 'clusterize.js';
import 'vuetify/dist/vuetify.min.css';

import Vue from 'vue';
import Vuetify from 'vuetify'
import theme from './theme';
import {setSystemBarColor} from './theme';
import MainContentHeaders from './components/Layout/MainContentHeader/MainContentHeaders';
import {shortcuts} from "./helpers/shortcuts";
import hotkeys from "hotkeys-js";

require('./vue-components');

Vue.use(VueRouter);
Vue.use(Vuetify);

const app = new Vue({
    el: '#root',
    router,
    store,
    vuetify: new Vuetify({
        theme,
        icons: {
            iconfont: 'mdiSvg',
        }
    }),
    data() {
        return {
            showSpotifyImport: false,
            isDarkTheme: localStorage.getItem('useDarkTheme') === '1',
            useExtraDarkTheme: false,
            statusInfo: {
                show: false,
                component: null,
                data: {},
            },
            mainContentHeaderComponent: MainContentHeaders.DEFAULT,
            user: window.currentUser,
            isTouch: false,
            isMobile: screen.width < 600,
            snackbar: {
                show: false,
                text: '',
                buttonText: 'close',
                callback: () => this.snackbar.show = false,
                color: undefined,
            },
        }
    },
    created() {
        this.detectTouch();
        setSystemBarColor('accent');
        this.initHotkeys();
        this.initSubContent();
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
        showAlert(text, color = 'info', buttonText = 'close', callback = () => this.snackbar.show = false) {
            this.snackbar.show = false;
            setTimeout(() => {
                this.snackbar.buttonText = buttonText;
                this.snackbar.text = text;
                this.snackbar.callback = callback;
                this.snackbar.show = true;
                this.snackbar.color = color;
            });
        },
        initHotkeys() {
            hotkeys(shortcuts.QUEUE_NEXT, () => this.$store.dispatch('player/addSelectedToQueue'));
        },
        initSubContent() {
            const subContent = this.user.sub_content || JSON.parse(localStorage.getItem('subContent')) || [];
            this.$store.commit('subContent/setSubContent', subContent);
        }
    },
    watch: {
        isDarkTheme(isDark) {
            this.$vuetify.theme.isDark = isDark;
            localStorage.setItem('useDarkTheme', 0 + isDark);
        }
    }
});

export default app;
