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
                    <v-btn text large icon :loading="loading" @click="togglePlay"
                           :aria-label="playing ? 'Pause' : 'Play'">
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
                               :src="albumCover"
                               height="50px"
                               max-height="50kpx"
                               max-width="50px"
                               width="50px"
                               contain
                               aspect-ratio="1"
                               style="z-index: -1"
                               class="hidden-md-and-up"></v-img>
                        <v-flex xs9 class="flex-center pl-4 pr-4 player-track-text"
                                @click="openFullscreenPlayer()">
                            <p class="ma-0 text-center w-100">
                                <span class="body-2">{{ title }}</span>
                                <br class="hidden-md-and-up">
                                <span class="hidden-md-and-down">&nbsp;&nbsp;</span>
                                <span
                                    class="caption grey--text font-weight-light">&diams;&nbsp;&nbsp;{{ artists }}</span>
                            </p>
                        </v-flex>
                        <v-flex xs3 class="flex-center pl-4 pr-2 hidden-md-and-down">
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
            <component :is="fullscreenVueComponent" :show.sync="showFullscreenPlayer"></component>
        </div>
    </div>
</template>

<script>
    import SpotifyPlayer from "./Spotify/SpotifyPlayer";
    import player from '$store/player/helpers/v2/player';
    import playerControlsMixin from "./playerControlsMixin";
    import Vue from 'vue';
    import PlayerFullscreenMobile from "$components/components/Player/Fullscreen/Mobile/Player";

    export default Vue.extend({
        name: "Player",
        components: {PlayerFullscreenMobile, SpotifyPlayer},
        mixins: [playerControlsMixin],
        data() {
            return {
                progressInterval: null,
                progressMs: 0,
                volumePercent: parseInt(localStorage.getItem('volume')) || 50,
                showFullscreenPlayer: false,
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
            },
            albumCover() {
                if (!this.currentTrack || !this.currentTrack.album) {
                    return window.playlistFallback;
                }

                return this.$root.getSpotifyImage(this.currentTrack.album, 'small');
            },
            fullscreenVueComponent() {
                return 'player-fullscreen-mobile';
                // TODO: implement desktop fullscreen player
                // return screen.width < 960 ? 'player-fullscreen-mobile' : 'player-fullscreen';
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
            openFullscreenPlayer() {
                if (screen.width < 960) {
                    this.showFullscreenPlayer = true;
                }
            }
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

    @media screen and (min-width: 0) and (max-width: 960px) {
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
                    line-height: 0;
                }
            }
        }
    }
</style>
