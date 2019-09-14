<template>
    <div class="player-wrapper">
        <v-slider class="player-progress-bar"
                  color="secondary"
                  v-model="progress"
                  :max="trackDuration"></v-slider>
        <div class="player-content">
            <div class="player-controls">
                <v-btn text icon aria-label="Play previous" :disabled="noPreviousTrack">
                    <v-icon @click="playPrevious">skip_previous</v-icon>
                </v-btn>
                <v-btn text icon :loading="loading" @click="togglePlay" :aria-label="playing ? 'Pause' : 'Play'">
                    <v-icon v-if="playing">pause_circle_filled</v-icon>
                    <v-icon v-else>play_circle_filled</v-icon>
                </v-btn>
                <v-btn text icon aria-label="Play next" :disabled="noNextTrack">
                    <v-icon @click="playNext">skip_next</v-icon>
                </v-btn>
            </div>
        </div>
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
            noNextTrack() {
                return !player.canPlayNext;
            },
            noPreviousTrack() {
                return !player.canPlayPrevious;
            },
            loading() {
                return player.isLoading;
            },
            progress: {
                get() {
                    return this.progressMs
                },
                set(milliseconds) {
                    clearInterval(this.progressInterval);
                    this.progressMs = milliseconds;
                    player.seek(milliseconds).then(this.setProgressInterval);
                }
            }
        },
        watch: {
            playing(playing) {
                if (playing) {
                    this.setProgressInterval();
                } else {
                    clearInterval(this.progressInterval);
                }
            }
        },
        methods: {
            setProgressInterval() {
                this.progressInterval = setInterval(() => this.progressMs += 100, 100);
            },
            togglePlay() {
                if (this.playing) {
                    player.pause();
                } else {
                    player.resume();
                }
            },
            playNext() {
                player.playNext();
            },
            playPrevious() {
                player.playPrevious();
            },
        }
    }
</script>

<style lang="scss">
    .player-wrapper {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        .player-progress-bar {
            margin: 0;
            position: absolute;
            top: calc(-50% + 2px);
            left: 0;
            width: 100%;
        }

        .player-content {
            display: flex;
        }
    }
</style>
