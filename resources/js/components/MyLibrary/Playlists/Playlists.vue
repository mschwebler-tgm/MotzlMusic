<template>
    <div>
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
            <h3 class="body-2 grey--text">Recent</h3>
            <playlist-item-list :playlists="playlists.recent"></playlist-item-list>
            <v-divider class="mt-2"></v-divider>
        </v-container>

        <v-container grid-list-lg justify-start v-if="playlists.spotify && playlists.spotify.length">
            <h3 class="body-2 grey--text">Spotify</h3>
            <playlist-item-list :playlists="playlists.spotify"></playlist-item-list>
<!--            <v-divider></v-divider>-->
        </v-container>

        <v-container grid-list-lg justify-start v-if="playlists.ungrouped && playlists.ungrouped.length">
            <h3 class="body-2 grey--text">Other</h3>
            <playlist-item-list :playlists="playlists.ungrouped"></playlist-item-list>
        </v-container>

        <v-container v-if="noPlaylistsAvailable">
            <div class="d-flex align-center flex-column">
                <p class="subheading text-center">You have no playlists in your library.</p>
                <div>
                    <v-btn color="primary" aria-label="Create playlist">create one!</v-btn>
                    <v-btn text color="primary" to="/import/spotify" aria-label="Import from spotify">Import from spotify</v-btn>
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
