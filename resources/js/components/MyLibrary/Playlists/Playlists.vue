<template>
    <div>
        <v-progress-circular
                v-if="!$parent.playlistsInitialized"
                color="primary"
                indeterminate>
        </v-progress-circular>
        <span class="headline">Playlists</span>
        <v-container grid-list-lg>
            <v-layout row wrap>
                <v-flex v-for="playlist in $parent.playlists"
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

    export default {
        name: "Playlists",
        components: {PlaylistItem}
    }
</script>

<style scoped>

</style>