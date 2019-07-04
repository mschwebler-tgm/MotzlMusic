<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <div class="playlist-actions">
        <v-btn flat class="hidden-sm-and-down">
            <v-icon>shuffle</v-icon>
            &nbsp;Shuffle
        </v-btn>
        <v-menu bottom left offset-x>
            <template v-slot:activator="{ on }">
                <v-btn flat icon v-on="on">
                    <v-icon>mdi-dots-vertical</v-icon>
                </v-btn>
            </template>
            <v-list>
                <v-list-tile class="hidden-md-and-up">
                    <v-list-tile-avatar>
                        <v-icon>shuffle</v-icon>
                    </v-list-tile-avatar>
                    <v-list-tile-content>Shuffle</v-list-tile-content>
                </v-list-tile>
                <v-divider></v-divider>
                <v-list-tile @click="makePrivate">
                    <v-list-tile-avatar>
                        <v-icon>visibility_off</v-icon>
                    </v-list-tile-avatar>
                    <v-list-tile-content>Make private</v-list-tile-content>
                </v-list-tile>
                <v-list-tile @click="subscribe">
                    <v-list-tile-avatar/>
                    <v-list-tile-content>Subscribe</v-list-tile-content>
                </v-list-tile>
                <v-divider></v-divider>
                <v-list-tile @click="download">
                    <v-list-tile-avatar>
                        <v-icon>cloud_download</v-icon>
                    </v-list-tile-avatar>
                    <v-list-tile-content>Download</v-list-tile-content>
                </v-list-tile>
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

</style>