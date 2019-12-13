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
                    meta: {
                        breadcrumb: [
                            { text: 'Profile' },
                        ],
                    },
                },
                {
                    path: 'settings',
                    name: 'settings',
                    component: Settings,
                    redirect: '/settings/general',
                    meta: {
                        breadcrumb: [
                            { text: 'Settings', to: '/settings' },
                        ],
                    },
                    children: [
                        {
                            path: 'general',
                            name: 'General',
                            component: SettingsGeneral,
                            meta: {
                                breadcrumb: [
                                    { text: 'Settings', to: '/settings' },
                                    { text: 'General', to: '/settings/general' },
                                ],
                            },
                        },
                        {
                            path: 'appearance',
                            name: 'Appearance',
                            component: SettingsAppearance,
                            meta: {
                                breadcrumb: [
                                    { text: 'Settings', to: '/settings' },
                                    { text: 'Appearance', to: '/settings/appearance' },
                                ],
                            },
                        },
                        {
                            path: 'notifications',
                            name: 'Notifications',
                            component: SettingsNotifications,
                            meta: {
                                breadcrumb: [
                                    { text: 'Settings', to: '/settings' },
                                    { text: 'Notifications', to: '/settings/notifications' },
                                ],
                            },
                        },
                        {
                            path: 'privacy',
                            name: 'Privacy',
                            component: SettingsPrivacy,
                            meta: {
                                breadcrumb: [
                                    { text: 'Settings', to: '/settings' },
                                    { text: 'Privacy', to: '/settings/privacy' },
                                ],
                            },
                        },
                        {
                            path: 'profile',
                            name: 'Profile',
                            component: SettingsProfile,
                            meta: {
                                breadcrumb: [
                                    { text: 'Settings', to: '/settings' },
                                    { text: 'Profile', to: '/settings/profile' },
                                ],
                            },
                        },
                        {
                            path: 'delete-account',
                            name: 'Delete Account',
                            component: SettingsDeleteAccount,
                            meta: {
                                breadcrumb: [
                                    { text: 'Settings', to: '/settings' },
                                    { text: 'Delete Account', to: '/settings/delete-account' },
                                ],
                            },
                        },
                    ],
                },
                {
                    path: 'import/spotify',
                    name: 'spotifyImport',
                    component: SpotifyImport,
                    meta: {
                        breadcrumb: [
                            { text: 'Spotify Import', to: '/import/spotify' },
                        ],
                    },
                },
                {
                    path: 'upload',
                    name: 'upload',
                    component: Upload,
                    meta: {
                        breadcrumb: [
                            { text: 'Upload', to: '/upload' },
                        ],
                    },
                },
                {
                    path: 'artist/:name/:id',
                    name: 'GlobalArtist',
                    component: Artist,
                    props: true,
                    meta: {
                        breadcrumb: [
                            { text: 'Artist' },
                        ],
                    },
                },
                {
                    path: 'my-library',
                    name: 'myLibrary',
                    component: MyLibrary,
                    redirect: '/my-library/playlists',
                    meta: {
                        breadcrumb: [
                            { text: 'My Library', to: '/my-library/playlists' },
                        ],
                    },
                    children: [
                        {
                            path: 'playlist/:name/:id',
                            component: PlaylistView,
                            props: true,
                            meta: {
                                breadcrumb: [
                                    { text: 'My Library', to: '/my-library/playlists' },
                                    { text: 'Playlists', to: '/my-library/playlists' },
                                    { text: 'Playlist' },
                                ],
                            },
                        },
                        {
                            path: 'playlists',
                            name: 'Playlists',
                            component: Playlists,
                            meta: {
                                breadcrumb: [
                                    { text: 'My Library', to: '/my-library/playlists' },
                                    { text: 'Playlists', to: '/my-library/playlists' },
                                ],
                            },
                        },
                        {
                            path: 'tracks',
                            name: 'Tracks',
                            component: Tracks,
                            meta: {
                                breadcrumb: [
                                    { text: 'My Library', to: '/my-library/playlists' },
                                    { text: 'Tracks', to: '/my-library/tracks' },
                                ],
                            },
                        },
                        {
                            path: 'albums',
                            name: 'Albums',
                            component: Albums,
                            meta: {
                                breadcrumb: [
                                    { text: 'My Library', to: '/my-library/playlists' },
                                    { text: 'Albums', to: '/my-library/albums' },
                                ],
                            },
                        },
                        {
                            path: 'album/:name/:id',
                            name: 'Album',
                            component: Album,
                            props: route => ({onlyOwnTracks: true, ...route.params}),
                            meta: {
                                breadcrumb: [
                                    { text: 'My Library', to: '/my-library/playlists' },
                                    { text: 'Albums', to: '/my-library/albums' },
                                    { text: 'Album' },
                                ],
                            },
                        },
                        {
                            path: 'artists',
                            name: 'Artists',
                            component: Artists,
                            meta: {
                                breadcrumb: [
                                    { text: 'My Library', to: '/my-library/playlists' },
                                    { text: 'Artists', to: '/my-library/artists' },
                                ],
                            },
                        },
                        {
                            path: 'artist/:name/:id',
                            name: 'Artist',
                            component: Artist,
                            props: route => ({onlyOwnTracks: true, ...route.params}),
                            meta: {
                                breadcrumb: [
                                    { text: 'My Library', to: '/my-library/playlists' },
                                    { text: 'Artists', to: '/my-library/artists' },
                                    { text: 'Artist' },
                                ],
                            },
                        },
                    ]
                }
            ],
        },
    ],
});
