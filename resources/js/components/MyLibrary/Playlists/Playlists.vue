<template>
    <div>
        <v-card-title class="headline">Playlists</v-card-title>
        <v-progress-circular
                v-if="!playlistsInitialized"
                color="primary"
                indeterminate>
        </v-progress-circular>

        <v-container grid-list-lg justify-start v-if="playlists.recent && playlists.recent.length">
            <h3 class="headline">Recent</h3>
            <playlist-item-list :playlists="playlists.recent"></playlist-item-list>
            <v-divider></v-divider>
        </v-container>

        <v-container grid-list-lg justify-start v-if="playlists.spotify && playlists.spotify.length">
            <h3 class="headline">Spotify</h3>
            <playlist-item-list :playlists="playlists.spotify"></playlist-item-list>
            <v-divider></v-divider>
        </v-container>

        <v-container grid-list-lg justify-start v-if="playlists.ungrouped && playlists.ungrouped.length">
            <h3 class="headline">Other</h3>
            <playlist-item-list :playlists="playlists.ungrouped"></playlist-item-list>
        </v-container>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex';
    import PlaylistItemList from "./PlaylistItemList";

    export default {
        name: "Playlists",
        components: {PlaylistItemList},
        computed: {
            ...mapGetters('myLibrary', [
                'playlists',
                'playlistsInitialized',
            ]),
        }
    }
</script>

<style scoped>

</style>
