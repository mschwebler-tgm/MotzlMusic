import VueRouter from 'vue-router';

import Master from './components/Layout/Master';
import Home from './components/Home/Home';
import Profile from './components/Profile/Profile';
import Settings from './components/Settings/Settings';
import SpotifyImport from './components/SpotifyImport/SpotifyImport';
import Upload from './components/Upload/Upload';

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
                    path: '/',
                    name: 'home',
                    component: Home,
                },
                {
                    path: '/profile/:id',
                    name: 'profile',
                    component: Profile,
                    props: true,
                },
                {
                    path: '/settings',
                    name: 'settings',
                    component: Settings,
                },
                {
                    path: '/import/spotify',
                    name: 'spotifyImport',
                    component: SpotifyImport,
                },
                {
                    path: '/upload',
                    name: 'upload',
                    component: Upload,
                },
           ],
        },
    ],
});
