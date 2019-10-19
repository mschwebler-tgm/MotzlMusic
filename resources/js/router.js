import VueRouter from 'vue-router';

import Master from './components/Layout/Master';
import Home from './components/Home/Home';
import Profile from './components/Profile/Profile';
import Settings from './components/Settings/Settings';
import SettingsGeneral from './components/Settings/Categories/General';
import SettingsDeleteAccount from './components/Settings/Categories/DeleteAccount';
import SettingsNotifications from './components/Settings/Categories/Notifications';
import SettingsPrivacy from './components/Settings/Categories/Privacy';
import SettingsProfile from './components/Settings/Categories/Profile';
import SettingsAppearance from "$scripts/components/Settings/Categories/Appearance";
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
                    redirect: '/settings/general',
                    children: [
                        {
                            path: 'general',
                            name: 'General',
                            component: SettingsGeneral,
                        },
                        {
                            path: 'appearance',
                            name: 'Appearance',
                            component: SettingsAppearance,
                        },
                        {
                            path: 'notifications',
                            name: 'Notifications',
                            component: SettingsNotifications,
                        },
                        {
                            path: 'privacy',
                            name: 'Privacy',
                            component: SettingsPrivacy,
                        },
                        {
                            path: 'profile',
                            name: 'Profile',
                            component: SettingsProfile,
                        },
                        {
                            path: 'delete-account',
                            name: 'Delete Account',
                            component: SettingsDeleteAccount,
                        },
                    ],
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
                            path: 'playlist/:name/:id',
                            component: PlaylistView,
                            props: true,
                        },
                        {
                            path: 'playlists',
                            name: 'Playlists',
                            component: Playlists,
                        },
                        {
                            path: 'tracks',
                            name: 'Tracks',
                            component: Tracks,
                        },
                        {
                            path: 'albums',
                            name: 'Albums',
                            component: Albums,
                        },
                        {
                            path: 'artists',
                            name: 'Artists',
                            component: Artists,
                        },
                    ]
                }
            ],
        },
    ],
});
