<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div id="master" @dragenter="dragging = true">
        <div v-show="dragging"
             @dragover="dragOver"
             @drop="drop"
             @dragend="dragEnd"
             @dragexit="dragEnd"
             @dragleave="dragEnd"
             id="drop-zone">
            <img src="/images/cloud_upload.svg" @dragover="dragOver">
        </div>
        <v-app>
            <!-- SIDE MENU -->
            <v-navigation-drawer v-model="showDrawer" clipped floating dark app
                                 :mobile-break-point="927">
                <v-toolbar flat class="transparent">
                    <v-list class="pa-0">
                        <v-list-item>
                            <v-list-item-avatar color="rgba(0, 0, 0, 0.5)">
                                <img :src="user.profile_image" :alt="user.name">
                            </v-list-item-avatar>

                            <v-list-item-content>
                                <v-list-item-title>{{ user.name }}</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-toolbar>

                <v-list dense expand>
                    <!-- HOME -->
                    <v-list-item @click="$router.push('/')">
                        <v-list-item-action>
                            <v-icon class="grey--text">home</v-icon>
                        </v-list-item-action>
                        <v-list-item-title>Home</v-list-item-title>
                    </v-list-item>
                    <v-divider></v-divider>

                    <!-- LIBRARY -->
                    <v-list-group prepend-icon="library_music"
                                  value="true"
                                  append-icon=""
                                  no-action>
                        <v-list-item slot="activator">
                            <v-list-item-title>My library</v-list-item-title>
                        </v-list-item>
                        <v-list-item to="/my-library/playlists" class="grey darken-4 white--text"
                                     active-class="accent white--text primary--text">
                            <v-list-item-title class="white--text">Playlists</v-list-item-title>
                            <v-list-item-action>
                                <v-icon>playlist_play</v-icon>
                            </v-list-item-action>
                        </v-list-item>
                        <v-divider inset></v-divider>
                        <v-list-item to="/my-library/tracks" class="grey darken-4 white--text"
                                     active-class="accent white--text primary--text">
                            <v-list-item-title class="white--text">Tracks</v-list-item-title>
                            <v-list-item-action>
                                <v-icon>music_note</v-icon>
                            </v-list-item-action>
                        </v-list-item>
                        <v-divider inset></v-divider>
                        <v-list-item to="/my-library/albums" class="grey darken-4 white--text"
                                     active-class="accent white--text primary--text">
                            <v-list-item-title class="white--text">Albums</v-list-item-title>
                            <v-list-item-action>
                                <v-icon>album</v-icon>
                            </v-list-item-action>
                        </v-list-item>
                        <v-divider inset></v-divider>
                        <v-list-item to="/my-library/artists" class="grey darken-4 white--text"
                                     active-class="accent white--text primary--text">
                            <v-list-item-title class="white--text">Artists</v-list-item-title>
                            <v-list-item-action>
                                <v-icon>account_box</v-icon>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list-group>
                    <v-divider></v-divider>

                    <!-- USER -->
                    <v-list-group prepend-icon="account_circle" no-action>
                        <v-list-item slot="activator">
                            <v-list-item-title>User</v-list-item-title>
                        </v-list-item>
                        <v-list-item to="/profile/me" class="grey darken-4 white--text"
                                     active-class="accent white--text primary--text">
                            <v-list-item-title class="white--text">Profile</v-list-item-title>
                            <v-list-item-action>
                                <v-icon>account_circle</v-icon>
                            </v-list-item-action>
                        </v-list-item>
                        <v-divider inset></v-divider>
                        <v-list-item to="/settings" class="grey darken-4 white--text"
                                     active-class="accent white--text primary--text">
                            <v-list-item-title class="white--text">Settings</v-list-item-title>
                            <v-list-item-action>
                                <v-icon>settings</v-icon>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list-group>
                    <v-divider></v-divider>

                    <!-- UPLOAD/IMPORT -->
                    <v-list-group no-action>
                        <v-list-item slot="activator">
                            <v-list-item-title>Manage content</v-list-item-title>
                        </v-list-item>
                        <v-list-item to="/import/spotify" class="grey darken-4 white--text"
                                     active-class="accent white--text primary--text">
                            <v-list-item-title class="white--text">Import from Spotify</v-list-item-title>
                            <v-list-item-action>
                                <img src="/images/spotify_black.png" alt="spotify-logo"
                                     class="spotify-logo invert--color" width="22" height="22">
                            </v-list-item-action>
                        </v-list-item>
                        <v-divider inset></v-divider>
                        <v-list-item to="/upload" class="grey darken-4 white--text"
                                     active-class="accent white--text primary--text">
                            <v-list-item-title class="white--text">Upload MP3s</v-list-item-title>
                            <v-list-item-action>
                                <v-icon>cloud_upload</v-icon>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list-group>
                    <v-divider></v-divider>

                    <!-- DARK -->
                    <v-list-item @click="$root.isDarkTheme = !$root.isDarkTheme">
                        <v-list-item-action>
                            <v-switch v-model="$root.isDarkTheme" id="menu__use-dark-theme"></v-switch>
                        </v-list-item-action>
                        <v-list-item-title tag="label">
                            <label for="menu__use-dark-theme">Use dark theme</label>
                        </v-list-item-title>
                    </v-list-item>
                    <v-divider></v-divider>

                    <!-- LOGOUT -->
                    <v-list-item @click="logout()" v-if="$root.isMobile">
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

            <!-- NAV BAR -->
            <v-app-bar app clipped-left dense color="primary" height="48">
                <v-app-bar-nav-icon @click="showDrawer = !showDrawer" aria-label="menu"></v-app-bar-nav-icon>
                <v-toolbar-title>MotzlMusic</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items class="hidden-sm-and-down">
                    <!--                    <v-btn text>Link One</v-btn>-->
                    <!--                    <v-btn text>Link Two</v-btn>-->
                    <v-menu transition="slide-y-transition"
                            :close-delay="500"
                            bottom left open-on-hover offset-y>
                        <template v-slot:activator="{on: menu}">
                            <v-btn v-on="menu" color="primary" depressed :ripple="false" aria-label="Profile">
                                {{ user.name }}
                            </v-btn>
                        </template>
                        <v-list dense>
                            <v-list-item @click="$router.push('/profile')">
                                <v-list-item-avatar>
                                    <v-icon class="grey--text">account_circle</v-icon>
                                </v-list-item-avatar>
                                <v-list-item-title>Profile</v-list-item-title>
                            </v-list-item>
                            <v-list-item @click="$router.push('/settings')">
                                <v-list-item-avatar>
                                    <v-icon class="grey--text">settings</v-icon>
                                </v-list-item-avatar>
                                <v-list-item-title>Settings</v-list-item-title>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-list-item @click="$router.push('/import/spotify')">
                                <v-list-item-avatar>
                                    <img src="/images/spotify_black.png" alt="spotify-logo"
                                         class="spotify-logo invert--color" width="22" height="22">
                                </v-list-item-avatar>
                                <v-list-item-title>Import from Spotify</v-list-item-title>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-list-item @click="$root.isDarkTheme = !$root.isDarkTheme">
                                <v-list-item-action>
                                    <v-switch v-model="$root.isDarkTheme" color="accent" id="nav__use-dark-theme"></v-switch>
                                </v-list-item-action>
                                <v-list-item-title>
                                    <label for="nav__use-dark-theme">Use dark theme</label>
                                </v-list-item-title>
                            </v-list-item>
                            <v-divider></v-divider>
                            <v-list-item @click="logout()">
                                <v-list-item-title>Logout</v-list-item-title>
                            </v-list-item>
                        </v-list>
                    </v-menu>
                </v-toolbar-items>
            </v-app-bar>

            <!-- CONTENT -->
            <v-content class="content-container">
                <v-container fluid grid-list-xl class="h-100">
                    <v-layout row wrap class="h-100">
                        <v-flex xs12 md12 lg12 xl9 class="xs-p0" style="max-height: 100%">
                            <component :is="$root.mainContentHeaderComponent"></component>
                            <!-- Main Content -->
                            <div class="main-content pb-4">
                                <transition name="bounce" mode="out-in">
                                    <router-view></router-view>
                                </transition>
                            </div>
                        </v-flex>
                        <v-flex xl3 class="hidden-lg-and-down">
                            <sub-content></sub-content>
                            <!-- Side Content -->
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>

            <v-snackbar
                    v-model="$root.snackbar.show"
                    :color="$root.snackbar.color"
                    :timeout="3000"
                    bottom>
                {{ $root.snackbar.text }}
                <v-btn color="white"
                       v-show="$root.snackbar.buttonText"
                       text
                       :aria-label="$root.snackbar.buttonText"
                       @click="$root.snackbar.callback">
                    {{ $root.snackbar.buttonText }}
                </v-btn>
            </v-snackbar>

            <!-- FOOTER -->
            <v-footer app height="36" style="z-index: 5;">
                <player></player>
            </v-footer>
        </v-app>
    </div>
</template>

<script>
    import Player from "../Player/Player";
    import SubContent from "./SubContent";
    import StatusInfo from "./StatusInfo/StatusInfo";
    import MainContentHeaderDefault from "./MainContentHeader/MainContentHeaderDefault";
    import MainContentHeaderMyLibraryNav from "./MainContentHeader/MainContentHeaderMyLibraryNav";

    export default {
        name: "master",
        components: {
            MainContentHeaderDefault,
            MainContentHeaderMyLibraryNav,
            StatusInfo,
            SubContent,
            Player
        },
        props: ['user'],
        data() {
            return {
                showDrawer: !this.$root.isMobile,
                dragging: false,
            }
        },
        created() {
            this.$root.showSpotifyImport = this.user && !this.user.spotify_import_complete;
            this.$root.user = this.user;
        },
        methods: {
            logout() {
                document.getElementById('logout-form').submit();
            },
            dragOver($event) {
                this.dragging = true;
                $event.preventDefault();
            },
            dragEnd() {
                this.dragging = false;
            },
            drop($event) {
                const files = $event.dataTransfer.files;
                if (!files.length) {
                    return;
                }
                $event.preventDefault();
                this.$store.commit('fileUpload/setFiles', [...files].filter(file => file.type === 'audio/mp3'));
                this.$store.dispatch('fileUpload/submit');
                this.dragging = false;
            }
        }
    }
</script>

<style scoped lang="scss">

    #drop-zone {
        content: '';
        position: absolute;
        width: 100vw;
        height: 100vh;
        z-index: 10000;
        background-color: rgba(0, 0, 0, 0.45);
        top: 0;
        display: flex;
        justify-content: center;
        align-items: center;

        img {
            width: 178px;
            height: 178px;
            filter: invert(100%);
        }
    }

    .bounce-enter-active {
        animation: bounce-in .2s;
    }

    .bounce-leave-active {
        animation: bounce-in .2s reverse;
    }

    .content-container {
        max-height: 100vh;
        overflow: hidden;
    }

    .main-content {
        max-height: 100%;
        overflow-y: scroll;

        &::-webkit-scrollbar {
            display: none;
        }
    }

    @keyframes bounce-in {
        0% {
            transform: scale(0.9);
            opacity: 0;
        }
        50% {
            transform: scale(1.005);
            opacity: .8;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
