import VueRouter from 'vue-router';

import GaussIndex from './components/Ideas/Gauss/Index.vue';
import SpotifyPlayer from './components/Experiments/SpotifyPlayer';
import IdeasInex from './components/Ideas/Index.vue';
import GlobalLibrary from './components/GlobalLibrary/Index.vue';
import MyLibrary from './components/MyLibrary/Index.vue';
import CreateSmartPlaylist from './components/CreateSmartPlaylist/Index.vue';
import NewUploads from './components/NewUploads/Index.vue';

import Master from './components/Layout/Master.vue';
import NotFoundPage from './components/Layout/NotFoundPage.vue';

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
                    path: '/experiments/spotify-player',
                    name: 'experiment_spotify-player',
                    component: SpotifyPlayer,
                },
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
        {
            path: '*',
            name: '404',
            component: NotFoundPage
        }
    ],
});
