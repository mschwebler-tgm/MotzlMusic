import Vue from "vue";

Vue.component('auth-login', require('./components/Auth/Login').default);
Vue.component('auth-register', require('./components/Auth/Register').default);

// sub components
Vue.component('sub-content-audio-features', require('$scripts/components/SubContent/Components/AudioFeatures').default);
Vue.component('sub-content-player-controls', require('$scripts/components/SubContent/Components/PlayerControls').default);
Vue.component('sub-content-track-info', require('$scripts/components/SubContent/Components/TrackInfo').default);
Vue.component('sub-content-current-tracks', require('$scripts/components/SubContent/Components/CurrentTracks').default);
