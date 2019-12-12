import VueRouter from 'vue-router';

import Master from './components/Layout/Master';
const Home = () => import('./components/Home/Home');
const Profile = () => import('./components/Profile/Profile');
const Settings = () => import('./components/Settings/Settings');
const SettingsGeneral = () => import('./components/Settings/Categories/General');
const SettingsDeleteAccount = () => import('./components/Settings/Categories/DeleteAccount');
const SettingsNotifications = () => import('./components/Settings/Categories/Notifications');
const SettingsPrivacy = () => import('./components/Settings/Categories/Privacy');
const SettingsProfile = () => import('./components/Settings/Categories/Profile');
const SettingsAppearance = () => import("./components/Settings/Categories/Appearance");
const SpotifyImport = () => import('./components/SpotifyImport/SpotifyImport');
const Upload = () => import('./components/Upload/Upload');
const MyLibrary = () => import('./components/MyLibrary/MyLibrary');
const Playlists = () => import('./components/MyLibrary/Playlists/Playlists');
const Tracks = () => import('./components/MyLibrary/Tracks/Tracks');
const Albums = () => import('./components/MyLibrary/Albums/Albums');
const Artists = () => import('./components/MyLibrary/Artists/Artists');
const PlaylistView = () => import('./components/Playlist/Playlist');
const Artist = () => import('./components/Artist/Artist');
const Album = () => import('./components/Album/Album');

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
                    path: 'artist/:name/:id',
                    name: 'Artist',
                    component: Artist,
                    props: true,
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
                            path: 'album/:name/:id',
                            name: 'Album',
                            component: Album,
                            props: route => ({onlyOwnTracks: true, ...route.params})
                        },
                        {
                            path: 'artists',
                            name: 'Artists',
                            component: Artists,
                        },
                        {
                            path: 'artist/:name/:id',
                            name: 'Artist',
                            component: Artist,
                            props: route => ({onlyOwnTracks: true, ...route.params})
                        },
                    ]
                }
            ],
        },
    ],
});
