<template>
    <div class="card">
        <div class="card-image">
            <figure class="image is-4by3">
                <img :src="album.spotify_image_medium" alt="Placeholder image">
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <p class="title is-5">{{ album.name }}</p>
                    <p class="subtitle is-6">{{ artists }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Album",
        props: ['album'],
        computed: {
            artists() {
                return this.album.artists.map(artist => artist.name).join(', ');
            }
        }
    }
</script>

<style scoped>
    .card {
        width: 200px;
        margin-right: 20px;
        margin-bottom: 20px;
    }
</style>