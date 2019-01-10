<template>
    <div>
        <b-loading :is-full-page="false" :active="!albumsInitialized"></b-loading>
        <h2 class="has-text-weight-light title is-9">Recent Albums</h2>
        <div class="flex flex-wrap">
            <album v-for="album in albums"
                   :album="album"
                   :key="album.id"></album>
        </div>
    </div>
</template>

<script>
    import BLoading from "buefy/src/components/loading/Loading";
    import Album from "./AlbumItem";

    export default {
        name: "Albums",
        components: {Album, BLoading},
        computed: {
            albums() {
                return this.$store.getters['myLibrary/albums'];
            },
            albumsInitialized() {
                return this.$store.getters['myLibrary/albumsInitialized'];
            }
        }
    }
</script>

<style scoped>

</style>