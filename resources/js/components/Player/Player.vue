<template>
    <div class="player-wrapper">
        <v-slider color="secondary" class="progress-bar" hide-details></v-slider>
        <spotify-player></spotify-player>
    </div>
</template>

<script>
    import SpotifyPlayer from "./Spotify/SpotifyPlayer";

    export default {
        name: "Player",
        components: {SpotifyPlayer},
    }
</script>

<style lang="scss">
    .player-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        width: 100%;
        height: 100%;

        .progress-bar {
            position: absolute;
            top: calc(-50% + 2px);
            left: 0;
            width: 100%;

            .v-slider {
                margin: 0;
            }
        }
    }
</style>
