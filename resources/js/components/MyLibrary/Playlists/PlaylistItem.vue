<template>
    <v-card tile @click="openPlaylistDetails" class="pointer playlist-tile">
        <v-img width="40%"
               :src="fullResolutionImage"
               :lazy-src="intermediateImage"
               :alt="playlist.name"
               style="display: inline-block;">
            <v-layout
                    slot="placeholder"
                    fill-height
                    align-center
                    justify-center
                    ma-0>
                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
            </v-layout>
        </v-img>
        <div style="display: inline-block; top: -10px; position: absolute;">
            <v-card-title primary-title>
                <h3 class="title mb-0">{{ playlist.name }}</h3>
            </v-card-title>
        </div>
    </v-card>
</template>

<script>
    export default {
        name: "PlaylistItem",
        props: {
            playlist: Object,
        },
        methods: {
            openPlaylistDetails() {
                this.$store.commit('cache/setSelectedPlaylist', this.playlist);
                this.$router.push(`/playlist/${this.playlist.name}/${this.playlist.id}`);
            }
        },
        computed: {
            fullResolutionImage() {
                return this.playlist.spotify_image_medium || this.playlist.spotify_image_large || '/images/playlistFallback.jpeg';
            },
            intermediateImage() {
                return this.playlist.spotify_image_small || this.playlist.spotify_image_medium || this.playlist.spotify_image_large || '/images/playlistFallback.jpeg';
            }
        }
    }
</script>

<style scoped>
    .playlist-tile.theme--dark {
        background-color: #343434;
        border-color: #343434;
    }
</style>