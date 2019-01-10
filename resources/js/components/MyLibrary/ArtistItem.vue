<template>
    <div class="card">
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
</template>

<script>
    import BIcon from "buefy/src/components/icon/Icon";

    export default {
        props: ['artist'],
        components: {BIcon},
    }
</script>

<style scoped>

    .card {
        width: 200px;
        margin-right: 20px;
        margin-bottom: 20px;
    }

    .image > img {
        object-fit: cover;
    }

</style>