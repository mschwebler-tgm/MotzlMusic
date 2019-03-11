<template>
    <div id="master">
        <v-app :dark="$root.isDarkTheme">
            <v-navigation-drawer v-model="showDrawer" app clipped floating dark
                                 :mobile-break-point="927">
                <v-toolbar flat class="transparent">
                    <v-list class="pa-0">
                        <v-list-tile avatar>
                            <v-list-tile-avatar>
                                <img src="https://randomuser.me/api/portraits/men/85.jpg">
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title>{{ user.name }}</v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-toolbar>

                <v-list>
                    <!-- HOME -->
                    <v-list-tile @click="$router.push('/')">
                        <v-list-tile-action>
                            <v-icon class="grey--text">home</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-title>Home</v-list-tile-title>
                    </v-list-tile>
                    <v-divider></v-divider>

                    <!-- LIBRARY -->
                    <v-list-group prepend-icon="library_music"
                                  value="true"
                                  append-icon=""
                                  no-action dense>
                        <v-list-tile slot="activator">
                            <v-list-tile-title>My library</v-list-tile-title>
                        </v-list-tile>
                        <v-list-tile to="/my-library/playlists" class="grey darken-4 white--text" exact-active-class="accent white--text primary--text">
                            <v-list-tile-title class="white--text">Playlists</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>playlist_play</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                        <v-divider inset></v-divider>
                        <v-list-tile to="/my-library/tracks" class="grey darken-4 white--text" exact-active-class="accent white--text primary--text">
                            <v-list-tile-title class="white--text">Tracks</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>music_note</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                        <v-divider inset></v-divider>
                        <v-list-tile to="/my-library/albums" class="grey darken-4 white--text" exact-active-class="accent white--text primary--text">
                            <v-list-tile-title class="white--text">Albums</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>album</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                        <v-divider inset></v-divider>
                        <v-list-tile to="/my-library/artists" class="grey darken-4 white--text" exact-active-class="accent white--text primary--text">
                            <v-list-tile-title class="white--text">Artists</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>account_box</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list-group>
                    <v-divider></v-divider>

                    <!-- USER -->
                    <v-list-group prepend-icon="account_circle"
                                  no-action>
                        <v-list-tile slot="activator">
                            <v-list-tile-title>User</v-list-tile-title>
                        </v-list-tile>
                        <v-list-tile to="/profile/me" class="grey darken-4 white--text" exact-active-class="accent white--text primary--text">
                            <v-list-tile-title class="white--text">Profile</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>account_circle</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                        <v-divider inset></v-divider>
                        <v-list-tile to="/settings" class="grey darken-4 white--text" exact-active-class="accent white--text primary--text">
                            <v-list-tile-title class="white--text">Settings</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>settings</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list-group>
                    <v-divider></v-divider>

                    <!-- UPLOAD/IMPORT -->
                    <v-list-group no-action>
                        <v-list-tile slot="activator">
                            <v-list-tile-title>Manage content</v-list-tile-title>
                        </v-list-tile>
                        <v-list-tile to="/import/spotify" class="grey darken-4 white--text" exact-active-class="accent white--text primary--text">
                            <v-list-tile-title class="white--text">Import from Spotify</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>cloud_download</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                        <v-divider inset></v-divider>
                        <v-list-tile to="/upload" class="grey darken-4 white--text" exact-active-class="accent white--text primary--text">
                            <v-list-tile-title class="white--text">Upload MP3s</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>cloud_upload</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list-group>
                    <v-divider></v-divider>

                    <!-- DARK -->
                    <v-list-tile @click="$root.isDarkTheme = !$root.isDarkTheme">
                        <v-list-tile-action>
                            <v-switch v-model="$root.isDarkTheme"></v-switch>
                        </v-list-tile-action>
                        <v-list-tile-title>
                            Use dark theme
                        </v-list-tile-title>
                    </v-list-tile>
                    <v-divider></v-divider>

                    <!-- LOGOUT -->
                    <v-list-tile @click="logout()">
                        <v-list-tile-title>Logout</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-navigation-drawer>
            <v-toolbar app color="primary" clipped-left>
                <v-toolbar-side-icon @click="showDrawer = !showDrawer"></v-toolbar-side-icon>
                <v-toolbar-title>Vuetify</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items class="hidden-sm-and-down">
                    <v-btn flat>Link One</v-btn>
                    <v-btn flat>Link Two</v-btn>
                    <v-menu transition="slide-y-transition"
                            :close-delay="500"
                            bottom left open-on-hover offset-y>
                        <v-btn slot="activator" color="primary" depressed :ripple="false">
                            {{ user.name }}
                        </v-btn>
                        <v-list>
                            <v-list-tile @click="$router.push('/profile')">
                                <v-list-tile-avatar>
                                    <v-icon class="grey--text">account_circle</v-icon>
                                </v-list-tile-avatar>
                                <v-list-tile-title>Profile</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile @click="$router.push('/settings')">
                                <v-list-tile-avatar>
                                    <v-icon class="grey--text">settings</v-icon>
                                </v-list-tile-avatar>
                                <v-list-tile-title>Settings</v-list-tile-title>
                            </v-list-tile>
                            <v-divider></v-divider>
                            <v-list-tile @click="$router.push('/import/spotify')">
                                <v-list-tile-avatar>
                                    <v-icon class="grey--text">cloud_download</v-icon>
                                </v-list-tile-avatar>
                                <v-list-tile-title>Import from Spotify</v-list-tile-title>
                            </v-list-tile>
                            <v-divider></v-divider>
                            <v-list-tile @click="$root.isDarkTheme = !$root.isDarkTheme">
                                <v-list-tile-action>
                                    <v-switch v-model="$root.isDarkTheme" color="accent"></v-switch>
                                </v-list-tile-action>
                                <v-list-tile-title>
                                    Use dark theme
                                </v-list-tile-title>
                            </v-list-tile>
                            <v-divider></v-divider>
                            <v-list-tile @click="logout()">
                                <v-list-tile-title>Logout</v-list-tile-title>
                            </v-list-tile>
                        </v-list>
                    </v-menu>
                </v-toolbar-items>
            </v-toolbar>
            <v-content>
                <v-container fluid grid-list-xl class="h-100">
                    <v-layout row wrap class="h-100">
                        <v-flex xs12 md12 lg12 xl9>
                            <!-- Main Content -->
                            <transition name="bounce" mode="out-in">
                                <router-view></router-view>
                            </transition>
                        </v-flex>
                        <v-flex xl3 class="hidden-lg-and-down">
                            <v-card style="height: 100%;">
                                <v-card-title>
                                    <span class="headline">

                                    Sub Content
                                    </span>
                                </v-card-title>
                            </v-card>
                            <!-- Side Content -->
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-content>
            <v-footer app></v-footer>
        </v-app>
    </div>
</template>

<script>
    export default {
        name: "master",
        props: ['user'],
        data() {
            return {
                showDrawer: true,
            }
        },
        created() {
            this.$root.showSpotifyImport = this.user && !this.user.spotify_import_complete;
        },
        methods: {
            logout() {
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>

<style scoped lang="scss">
    .bounce-enter-active {
        animation: bounce-in .2s;
    }
    .bounce-leave-active {
        animation: bounce-in .2s reverse;
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
