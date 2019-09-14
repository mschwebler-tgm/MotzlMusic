<template>
    <div class="player-wrapper">
        <v-slider class="player-progress-bar"
                  color="secondary"
                  v-model="progress"
                  :max="trackDuration"></v-slider>
        <spotify-player></spotify-player>
    </div>
</template>

<script>
    import SpotifyPlayer from "./Spotify/SpotifyPlayer";
    import player from '$store/player/helpers/v2/player';

    export default {
        name: "Player",
        components: {SpotifyPlayer},
        data() {
            return {
                progressInterval: null,
                progressMs: 0,
            }
        },
        computed: {
            playing() {
                return player.isPlaying;
            },
            trackDuration() {
                return player.currentTrack ? player.currentTrack.duration : 0;
            },
            progress: {
                get() {
                    return this.progressMs
                },
                set(milliseconds) {
                    player.seek(milliseconds);
                    this.progressMs = milliseconds;
                }
            }
        },
        watch: {
            playing(playing) {
                if (playing) {
                    this.progressInterval = setInterval(() => this.progressMs += 100, 100);
                } else {
                    clearInterval(this.progressInterval);
                }
            }
        }
    }
</script>

<style lang="scss">
    .player-wrapper {
        width: 100%;
        height: 100%;

        .player-progress-bar {
            margin: 0;
            position: absolute;
            top: calc(-50% + 2px);
            left: 0;
            width: 100%;
        }
    }
</style>
