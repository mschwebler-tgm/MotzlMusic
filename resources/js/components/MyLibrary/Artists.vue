<template>
    <div class="h-100 clusterize flex-column">
        <b-loading :active="!topArtistsInitialized" :is-full-page="false"></b-loading>
        <h2 class="has-text-weight-light title is-9">Top Artists</h2>
        <div v-if="topArtistsInitialized" class="artists-wrapper">
            <div class="artist" v-for="artist in topArtists">
                <div class="artist-content">
                    <img :src="artist.spotify_image_medium" class="artist-image">
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BLoading from "buefy/src/components/loading/Loading";

    export default {
        name: "artist",
        components: {BLoading},
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

<style scoped>
    .artists-wrapper {
        display: flex;
        flex-wrap: wrap;
    }
    .artist {
        min-width: 200px;
        max-width: 400px;
        flex: 1;
        position: relative;
    }
    .artist:after {
        padding-top: 100%;
        display: block;
        content: '';
    }
    .artist-content {
        position: absolute;
        height: 100%;
        width: 100%;
        overflow: hidden;
    }
    .artist-image {
        width:100%;
        height:100%;
        object-fit: cover;
        overflow: hidden;
    }
</style>