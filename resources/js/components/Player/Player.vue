<template>
    <div class="footer-height">
        <div class="player-wrapper">
            <v-slider hide-details
                      v-model="progress"
                      :max="trackDuration"
                      class="player-progress-bar"
                      color="secondary"></v-slider>
            <div class="player-content">
                <div class="player-controls">
                    <v-btn text icon aria-label="Play previous" :disabled="noPreviousTrack">
                        <v-icon @click="playPrevious">skip_previous</v-icon>
                    </v-btn>
                    <v-btn text large icon :loading="loading" @click="togglePlay" :aria-label="playing ? 'Pause' : 'Play'">
                        <v-icon v-if="playing">pause_circle_filled</v-icon>
                        <v-icon v-else>play_circle_filled</v-icon>
                    </v-btn>
                    <v-btn text icon aria-label="Play next" :disabled="noNextTrack">
                        <v-icon @click="playNext">skip_next</v-icon>
                    </v-btn>
                </div>
                <v-container fluid class="pt-0 pb-0">
                    <v-layout row wrap class="h-100">
                        <v-img v-if="currentTrack"
                               :src="$root.getSpotifyImage(currentTrack, 'medium')"
                               height="50px"
                               max-height="50kpx"
                               max-width="50px"
                               width="50px"
                               contain
                               aspect-ratio="1"
                               style="z-index: -1"
                               class="hidden-sm-and-up"></v-img>
                        <v-flex xs9 class="flex-center pl-4 pr-4 player-track-text">
                            <span class="subtitle-2">{{ title }}</span>
                            <span class="grey--text">&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                            <span class="body-2">{{ artists }}</span>
                        </v-flex>
                        <v-flex xs3 class="flex-center pl-4 pr-2 hidden-xs-only">
                            <v-slider v-model="volume"
                                      hide-details
                                      thumb-label
                                      thumb-size="24"
                                      min="0"
                                      max="100"
                                      prepend-icon="volume_up"
                                      color="grey"></v-slider>
                        </v-flex>
                    </v-layout>
                </v-container>
            </div>
            <spotify-player></spotify-player>
        </div>
    </div>
</template>

<script>
    import SpotifyPlayer from "./Spotify/SpotifyPlayer";
    import player from '$store/player/helpers/v2/player';
    import playerControlsMixin from "./playerControlsMixin";
    import Vue from 'vue';

    export default Vue.extend({
        name: "Player",
        components: {SpotifyPlayer},
        mixins: [playerControlsMixin],
        data() {
            return {
                progressInterval: null,
                progressMs: 0,
                volumePercent: parseInt(localStorage.getItem('volume')) || 50
            }
        },
        computed: {
            progress: {
                get() {
                    return this.progressMs
                },
                set(milliseconds) {
                    clearInterval(this.progressInterval);
                    this.progressMs = milliseconds;
                    player.seek(milliseconds).then(this.setProgressInterval);
                }
            },
            playerProgress() {
                return player.progress;
            },
            volume: {
                get() {
                    return this.volumePercent;
                },
                set(volume) {
                    localStorage.setItem('volume', volume);
                    player.setVolume(volume);
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
            },
            playerProgress(progress) {
                this.progressMs = progress;
            }
        },
        methods: {
            setProgressInterval() {
                this.progressInterval = setInterval(() => this.progressMs += 100, 100);
            },
        }
    });
</script>

<style lang="scss">
    .footer-height {
        height: 36px;

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

                .v-slider {
                    margin: 0;
                }
            }

            .player-content {
                max-height: 100%;
                height: 100%;
                display: flex;

                .player-controls {
                    min-width: 256px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
            }
        }
    }

    .flex-center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @media screen and (min-width: 0) and (max-width: 599px) {
        .footer-height {
            height: 50px;

            .player-progress-bar {
                top: calc(-50% + 10px) !important;
            }

            .player-content {
                flex-direction: row-reverse;

                .player-controls {
                    min-width: 110px !important;
                    flex: 0;
                }

                .player-track-text {
                    justify-content: flex-start;
                }
            }
        }
    }
</style>
