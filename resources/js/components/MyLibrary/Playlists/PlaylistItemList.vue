<template>
    <v-container grid-list-lg justify-start class="ml-0">
        <v-layout row wrap>
            <v-flex v-for="playlist in playlists"
                    :key="playlist.id"
                    xs12 sm6 md4 lg4 xl3 d-block justify-center>
                <playlist-item :playlist="playlist"></playlist-item>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import PlaylistItem from "./PlaylistItem";

    export default {
        name: "PlaylistItemList",
        components: {PlaylistItem},
        props: {
            playlists: {
                type: Array,
                default: () => [],
            }
        }
    }
</script>

<style scoped>

</style>
