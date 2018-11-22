import VueRouter from 'vue-router';

import GaussIndex from './components/Ideas/Gauss/Index.vue';
import IdeasInex from './components/Ideas/Index.vue';
import GlobalLibrary from './components/GlobalLibrary/Index.vue';
import MyLibrary from './components/MyLibrary/Index.vue';
import CreateSmartPlaylist from './components/CreateSmartPlaylist/Index.vue';
import NewUploads from './components/NewUploads/Index.vue';

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
                {
                    path: 'global-library',
                    name: 'global_library',
                    component: GlobalLibrary,
                },
                {
                    path: 'my-library',
                    name: 'my_library',
                    component: MyLibrary,
                },
                {
                    path: 'create-smart-playlist',
                    name: 'create_smart_playlist',
                    component: CreateSmartPlaylist,
                },
                {
                    path: 'new',
                    name: 'new_uploads',
                    component: NewUploads,
                }
            ],
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
