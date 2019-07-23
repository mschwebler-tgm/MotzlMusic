<template>
    <v-card>
        <v-container><h2 class="headline">Settings</h2></v-container>
        <v-container class="settings-wrapper">
            <v-list class="settings-menu" subheader>
                <v-divider></v-divider>
                <template v-for="setting in settings">
                    <v-list-tile :to="setting.to">
                        <v-list-tile-content>
                            <v-list-tile-title>{{ setting.name }}</v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-divider></v-divider>
                </template>
            </v-list>
            <v-container class="settings-content">
                <router-view></router-view>
            </v-container>
        </v-container>
    </v-card>
</template>

<script>
    export default {
        name: "Settings",
        data() {
            return {
                settings: [
                    {
                        name: 'General',
                        to: '/settings/general',
                    },
                    {
                        name: 'Notifications',
                        to: '/settings/notifications',
                    },
                    {
                        name: 'Privacy',
                        to: '/settings/privacy',
                    },
                    {
                        name: 'Profile',
                        to: '/settings/profile',
                    },
                    {
                        name: 'Delete Account',
                        to: '/settings/delete-account',
                    },
                ]
            }
        },
    }
</script>

<style scoped>
    .settings-wrapper {
        display: flex;
    }

    .settings-menu {
        border-left: 1px solid hsla(0,0%,100%,.12);
        border-right: 1px solid hsla(0,0%,100%,.12);
        padding: 0;
    }

    .settings-content {
        flex: 1;
    }
</style>
