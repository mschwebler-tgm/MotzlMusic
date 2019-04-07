<template>
        <v-layout row wrap>
            <v-flex v-for="playlist in playlists"
                    :key="playlist.id"
                    xs6 sm4 md4 lg3 xl2 d-block justify-center>
                <playlist-item :playlist="playlist"></playlist-item>
            </v-flex>
        </v-layout>
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
