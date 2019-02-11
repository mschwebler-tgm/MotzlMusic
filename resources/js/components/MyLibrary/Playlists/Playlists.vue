<template>
    <div>
        <v-card-title class="headline">Playlists</v-card-title>
        <v-progress-circular
                v-if="!playlistsInitialized"
                color="primary"
                indeterminate>
        </v-progress-circular>

        <v-container grid-list-lg>
            <v-layout row wrap>
                <v-flex v-for="playlist in playlists"
                        :key="playlist.id"
                        xs12 sm6 md4 lg4 xl3 d-block justify-center>
                    <playlist-item :playlist="playlist"></playlist-item>
                </v-flex>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import PlaylistItem from "./PlaylistItem";
    import {mapGetters} from 'vuex';

    export default {
        name: "Playlists",
        components: {PlaylistItem},
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