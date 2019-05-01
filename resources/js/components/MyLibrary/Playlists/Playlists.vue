<template>
    <div>
        <v-card-title class="headline">Playlists</v-card-title>
        <v-container v-if="!playlistsInitialized">
            <div class="d-flex justify-center">
                <v-progress-circular
                        v-if="!playlistsInitialized"
                        color="primary"
                        indeterminate>
                </v-progress-circular>
            </div>
        </v-container>

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

        <v-container v-if="noPlaylistsAvailable">
            <div class="d-flex align-center flex-column">
                <p class="subheading text-xs-center">You have no playlists in your library.</p>
                <div>
                    <v-btn color="primary">create one!</v-btn>
                    <v-btn flat color="primary" to="/import/spotify">Import from spotify</v-btn>
                </div>
            </div>
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
            noPlaylistsAvailable() {
                return this.playlistsInitialized && !Object.values(this.playlists).some(playlist => playlist.length > 0);
            }
        }
    }
</script>

<style scoped>

</style>
