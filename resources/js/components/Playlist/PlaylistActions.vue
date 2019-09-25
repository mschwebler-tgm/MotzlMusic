<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div :class="{'playlist-actions': !$root.isMobile}">
        <v-btn text class="hidden-sm-and-down">
            <v-icon>shuffle</v-icon>
            &nbsp;Shuffle
        </v-btn>
        <v-menu bottom left offset-x>
            <template v-slot:activator="{ on: menu }">
                <v-btn text icon v-on="menu" aria-label="Playlist Options">
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>
            </template>
            <v-list>
                <v-list-item class="hidden-md-and-up">
                    <v-list-item-avatar>
                        <v-icon>shuffle</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>Shuffle</v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item @click="makePrivate">
                    <v-list-item-avatar>
                        <v-icon>visibility_off</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>Make private</v-list-item-content>
                </v-list-item>
                <v-list-item @click="subscribe">
                    <v-list-item-avatar/>
                    <v-list-item-content>Subscribe</v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item @click="download">
                    <v-list-item-avatar>
                        <v-icon>cloud_download</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>Download</v-list-item-content>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
    export default {
        name: "PlaylistActions",
        props: ['playlistId'],
        methods: {
            makePrivate() {
                // TODO
            },
            subscribe() {
                // TODO
            },
            download() {
                // TODO
            },
        }
    }
</script>

<style scoped>
    .playlist-actions {
        position: absolute;
        bottom: 12px;
        right: 0;
        display: flex;
    }
</style>