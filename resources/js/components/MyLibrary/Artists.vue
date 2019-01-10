<template>
    <div class="h-100 clusterize flex-column">
        <b-loading :active="!topArtistsInitialized" :is-full-page="false"></b-loading>
        <h2 class="has-text-weight-light title is-9">Top Artists</h2>
        <div v-if="topArtistsInitialized" class="artists-wrapper">
            <div class="card" v-for="artist in topArtists">
                <div class="card-image">
                    <figure class="image is-4by3">
                        <img :src="artist.spotify_image_medium" :alt="artist.name">
                    </figure>
                </div>
                <div class="card-content">
                    <div class="media">
                        <div class="media-content">
                            <p class="title is-5">{{ artist.name }}</p>
                            <p class="subtitle is-6">
                                <b-icon icon="music" size="is-small"></b-icon>
                                {{ artist.track_amount }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BLoading from "buefy/src/components/loading/Loading";
    import BIcon from "buefy/src/components/icon/Icon";

    export default {
        name: "artist",
        components: {BIcon, BLoading},
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

    .card {
        width: 200px;
        margin-right: 20px;
        margin-bottom: 20px;
    }

    .image > img {
        object-fit: cover;
    }

</style>