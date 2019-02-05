import VueRouter from 'vue-router';

import Master from './components/Layout/Master.vue';

export default new VueRouter({
    mode: 'history',
    base: __dirname,
    linkExactActiveClass: 'is-active',
    routes: [
        {
            path: '/',
            name: 'master',
            component: Master,
            props: true,
            children: [
            ],
        },
    ],
});
