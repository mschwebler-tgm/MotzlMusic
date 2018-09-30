require('./bootstrap');

window.Vue = require('vue');

Vue.component('gauss', require('./components/Ideas/Gauss.vue'));
Vue.component('gauss-wrapper', require('./components/Ideas/GaussWrapper.vue'));

const app = new Vue({
    el: '#root',
  });
