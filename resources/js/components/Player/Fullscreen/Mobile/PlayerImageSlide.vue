<template>
    <div class="fullscreen-player-track-image-container">
        <v-img class="elevation-15"
               :src="albumCover"
               max-width="100%"
               width="100%"
               contain
               aspect-ratio="1"></v-img>
    </div>
</template>

<script>
    export default {
        name: "PlayerImageSlide",
        props: {
            track: Object,
        },
        computed: {
            albumCover() {
                if (!this.track || !this.track.album) {
                    return window.playlistFallback;
                }

                return this.$root.getSpotifyImage(this.track.album, 'small');
            }
        }
    }
</script>

<style scoped>

    .fullscreen-player-track-image-container {
        display: flex;
        justify-content: center;
    }

</style>