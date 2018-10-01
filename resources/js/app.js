require('./bootstrap');

import VueRouter from 'vue-router';
import router from './router';

window.Vue = require('vue');

Vue.component('gauss', require('./components/Ideas/Gauss/Gauss.vue'));
Vue.component('gauss-wrapper', require('./components/Ideas/Gauss/GaussWrapper.vue'));

Vue.use(VueRouter);

const app = new Vue({
    el: '#root',
    router
  });
