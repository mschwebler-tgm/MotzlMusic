<template>
    <div class="position-relative">
        <b-loading :is-full-page="false" :active="playlistsLoading"></b-loading>
        <h2 class="has-text-weight-light title is-9">Newest</h2>
        <div class="flex flex-wrap">
            <playlist v-for="playlist in playlists" :playlist="playlist" :key="playlist.id"></playlist>
        </div>
        <!--<h2 class="has-text-weight-light title is-9">Automatic Playlists</h2>-->
        <!--<div class="flex flex-wrap">-->
        <!--<playlist></playlist>-->
        <!--</div>-->
        <!--<h2 class="has-text-weight-light title is-9">Subscribed Playlists</h2>-->
        <!--<div class="flex flex-wrap">-->
        <!--<playlist></playlist>-->
        <!--</div>-->
        <div class="has-text-centered" style="padding: 65px;">
            No more playlists found. <a href="#">Create new!</a>
        </div>
    </div>
</template>

<script>
    import Playlist from "./PlaylistItem";
    import BLoading from "buefy/src/components/loading/Loading";

    export default {
        name: "Playlists",
        components: {BLoading, Playlist},
        computed: {
            playlists() {
                return this.$store.getters['myLibrary/playlists'];
            },
            playlistsLoading() {
                return !this.$store.getters['myLibrary/playlistsInitialized'];
            }
        }
    }
</script>

<style scoped>

</style>