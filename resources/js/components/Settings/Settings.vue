<template>
    <v-card>
        <v-container class="pa-5"><h2 class="headline">Settings</h2></v-container>
        <v-container class="settings-wrapper pa-5">
            <v-list class="settings-menu" subheader>
                <v-divider></v-divider>
                <template v-for="setting in settings">
                    <v-list-item :to="setting.to">
                        <v-list-item-content>
                            <v-list-item-title>{{ setting.name }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider></v-divider>
                </template>
            </v-list>
            <div class="settings-content">
                <transition name="settings" mode="out-in">
                    <router-view></router-view>
                </transition>
            </div>
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
        align-items: flex-start;
    }

    .settings-menu {
        border-left: 1px solid hsla(0,0%,100%,.12);
        border-right: 1px solid hsla(0,0%,100%,.12);
        padding: 0;
    }

    .settings-content {
        flex: 1;
        padding: 0 24px;
    }

    .settings-enter {
        -webkit-transform: translate3d(-5px, 0, 0);
        -moz-transform: translate3d(-5px, 0, 0);
        -ms-transform: translate3d(-5px, 0, 0);
        -o-transform: translate3d(-5px, 0, 0);
        transform: translate3d(-5px, 0, 0);
        opacity: 0;
    }

    .settings-enter-to {
        -webkit-transform: translate3d(0, 0, 0);
        -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
        -o-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        opacity: 1;
    }

    .settings-enter-active, .settings-leave-active {
        -webkit-transition: transform .15s ease-in-out, opacity .15s ease-in;
        -moz-transition: transform .15s ease-in-out, opacity .15s ease-in;
        -ms-transition: transform .15s ease-in-out, opacity .15s ease-in;
        -o-transition: transform .15s ease-in-out, opacity .15s ease-in;
        transition: transform .15s ease-in-out, opacity .15s ease-in;
    }

    .settings-leave {
        -webkit-transform: translate3d(0, 0, 0);
        -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
        -o-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0);
        opacity: 1;
    }

    .settings-leave-to {
        -webkit-transform: translate3d(-5px, 0, 0);
        -moz-transform: translate3d(-5px, 0, 0);
        -ms-transform: translate3d(-5px, 0, 0);
        -o-transform: translate3d(-5px, 0, 0);
        transform: translate3d(-5px, 0, 0);
        opacity: 0;
    }
</style>
