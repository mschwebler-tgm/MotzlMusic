<template>
    <div class="h-100 clusterize flex-column">
        <b-loading :active="!topArtistsInitialized" :is-full-page="false"></b-loading>
        <h2 class="has-text-weight-light title is-9">Top Artists</h2>
        <div v-if="topArtistsInitialized" class="artists-wrapper">
            <artist-item :artist="artist" v-for="artist in topArtists"></artist-item>
        </div>
    </div>
</template>

<script>
    import BLoading from "buefy/src/components/loading/Loading";
    import ArtistItem from "./ArtistItem";

    export default {
        name: "artist",
        components: {ArtistItem, BLoading},
        computed: {
            topArtists() {
                return this.$store.getters['myLibrary/topArtists'];
            },
            topArtistsInitialized() {
                return this.$store.getters['myLibrary/topArtistsInitialized'];
            }
        }
    }
</script>

<style scoped lang="scss">

    .artists-wrapper {
        display: flex;
        flex-wrap: wrap;
    }

</style>