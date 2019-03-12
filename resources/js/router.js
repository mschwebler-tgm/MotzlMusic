import VueRouter from 'vue-router';

import Master from './components/Layout/Master';
import Home from './components/Home/Home';
import Profile from './components/Profile/Profile';
import Settings from './components/Settings/Settings';
import SpotifyImport from './components/SpotifyImport/SpotifyImport';
import Upload from './components/Upload/Upload';
import MyLibrary from './components/MyLibrary/MyLibrary';
import Playlists from './components/MyLibrary/Playlists/Playlists';
import Tracks from './components/MyLibrary/Tracks/Tracks';
import Albums from './components/MyLibrary/Albums/Albums';
import Artists from './components/MyLibrary/Artists/Artists';
import PlaylistView from './components/Playlist/Playlist';

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
                    path: 'profile/:id',
                    name: 'profile',
                    component: Profile,
                    props: true,
                },
                {
                    path: 'settings',
                    name: 'settings',
                    component: Settings,
                },
                {
                    path: 'import/spotify',
                    name: 'spotifyImport',
                    component: SpotifyImport,
                },
                {
                    path: 'upload',
                    name: 'upload',
                    component: Upload,
                },
                {
                    path: 'my-library',
                    name: 'myLibrary',
                    component: MyLibrary,
                    redirect: '/my-library/playlists',
                    children: [
                        {
                            path: 'playlists/:name/:id',
                            name: 'playlists',
                            component: PlaylistView,
                            props: true,
                        },
                        {
                            path: 'playlists',
                            name: 'playlists',
                            component: Playlists,
                        },
                        {
                            path: 'tracks',
                            name: 'tracks',
                            component: Tracks,
                        },
                        {
                            path: 'albums',
                            name: 'albums',
                            component: Albums,
                        },
                        {
                            path: 'artists',
                            name: 'artists',
                            component: Artists,
                        },
                    ]
                }
           ],
        },
    ],
});
