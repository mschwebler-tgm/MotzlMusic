<template>
    <div class="card">
        <div class="card-image">
            <figure class="image is-4by3">
                <img :src="playlist.spotify_image_medium" :alt="playlist.name">
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-content">
                    <p class="title is-5">{{ playlist.name }}</p>
                    <p class="subtitle is-6">Playlist</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "playlistItem",
        props: ['playlist']
    }
</script>

<style scoped lang="scss">
    .card {
        width: 200px;
        margin-right: 20px;
        margin-bottom: 20px;
    }
</style>