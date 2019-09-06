// import Vue from 'vue';

// Vue.config.productionTip = false;
// Vue.config.silent = false;
// Csrf token to avoid laravel error message
let meta = document.createElement('meta');
meta.name = "csrf-token";
meta.content = "csrf-token";
window.Laravel = {csrfToken: "csrf-token"};
document.getElementsByTagName('head')[0].appendChild(meta);

// require('../bootstrap');

// require all test files (files that ends with .spec.js)
const testsContext = require.context('./spec', true, /\.spec$/);
testsContext.keys().forEach(testsContext);
