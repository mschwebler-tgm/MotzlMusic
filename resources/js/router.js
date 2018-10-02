import VueRouter from 'vue-router';

import GaussIndex from './components/Ideas/Gauss/Index.vue';
import IdeasInex from './components/Ideas/Index.vue';

import Master from './components/Master.vue';

export default new VueRouter({
    mode: 'history',
    base: __dirname,
    routes: [
        {
            path: '/',
            name: 'master',
            component: Master,
        },
        {
            path: '/ideas',
            name: 'index',
            component: IdeasInex,
            children: [
                {
                    path: '/ideas/gauss',
                    name: 'idea_gauss',
                    component: GaussIndex,
                    props: true,
                },
            ],
        },
    ],
});
