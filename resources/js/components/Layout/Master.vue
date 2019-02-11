<template>
    <div id="master">
        <v-app :dark="$root.isDarkTheme">
            <v-navigation-drawer v-model="showDrawer" app clipped floating>
                <v-toolbar flat class="transparent">
                    <v-list class="pa-0">
                        <v-list-tile avatar>
                            <v-list-tile-avatar>
                                <img src="https://randomuser.me/api/portraits/men/85.jpg">
                            </v-list-tile-avatar>

                            <v-list-tile-content>
                                <v-list-tile-title>John Leider</v-list-tile-title>
                            </v-list-tile-content>
                        </v-list-tile>
                    </v-list>
                </v-toolbar>
                <v-list>
                    <v-list-tile @click="$router.push('/')">
                        <v-list-tile-action>
                            <v-icon class="grey--text">home</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-title>Home</v-list-tile-title>
                    </v-list-tile>
                    <v-divider></v-divider>
                    <v-list-group prepend-icon="account_circle"
                                  value="true"
                                  no-action>
                        <v-list-tile slot="activator">
                            <v-list-tile-title>User</v-list-tile-title>
                        </v-list-tile>
                        <v-list-tile @click="$router.push('/profile/me')">
                            <v-list-tile-title>Profile</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>account_circle</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>
                        <v-list-tile @click="$router.push('/settings')">
                            <v-list-tile-title>Settings</v-list-tile-title>
                            <v-list-tile-action>
                                <v-icon>settings</v-icon>
                            </v-list-tile-action>
                        </v-list-tile>

                        <v-list-group no-action sub-group>
                            <v-list-tile slot="activator">
                                <v-list-tile-title>Manage content</v-list-tile-title>
                            </v-list-tile>
                            <v-list-tile @click="$root.showSpotifyImport = true">
                                <v-list-tile-title>Import from Spotify</v-list-tile-title>
                                <v-list-tile-action>
                                    <v-icon>cloud_download</v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                            <v-list-tile @click="$router.push('/upload')">
                                <v-list-tile-title>Upload MP3s</v-list-tile-title>
                                <v-list-tile-action>
                                    <v-icon>cloud_upload</v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list-group>
                    </v-list-group>
                    <v-divider></v-divider>
                    <v-list-tile @click="$root.isDarkTheme = !$root.isDarkTheme">
                        <v-list-tile-action>
                            <v-switch v-model="$root.isDarkTheme"></v-switch>
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
            </v-navigation-drawer>
            <v-toolbar app color="info" clipped-left>
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
                            <v-list-tile @click="$root.showSpotifyImport = true">
                                <v-list-tile-avatar>
                                    <v-icon class="grey--text">cloud_download</v-icon>
                                </v-list-tile-avatar>
                                <v-list-tile-title>Import from Spotify</v-list-tile-title>
                            </v-list-tile>
                            <v-divider></v-divider>
                            <v-list-tile @click="$root.isDarkTheme = !$root.isDarkTheme">
                                <v-list-tile-action>
                                    <v-switch v-model="$root.isDarkTheme"></v-switch>
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
                <v-container fluid>
                    <router-view></router-view>
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
                sideMenu: [
                    {
                        isGroup: false, label: 'Home', icon: 'home', iconClass: 'has-text--grey'
                    },
                    {
                        isGroup: true, label: 'User', icon: 'account', iconClass: 'has-text--info', items: [
                            {
                                isGroup: false, label: 'Profile', iconClass: 'has-text--grey'
                            },
                            {
                                isGroup: false, label: 'Settings', icon: 'settings', iconClass: 'has-text--grey'
                            }
                        ]
                    },
                    {
                        isGroup: true, label: 'Manage content', icon: 'music', iconClass: 'has-text--grey', items: [
                            {
                                isGroup: false, label: 'Profile', iconClass: 'has-text--grey'
                            },
                            {
                                isGroup: false, label: 'Settings', icon: 'settings', iconClass: 'has-text--grey'
                            }
                        ]
                    }
                ]
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
</style>
