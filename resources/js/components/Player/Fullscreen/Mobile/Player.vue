<template>
    <v-expand-transition>
        <div class="fullscreen-player grey darken-4" v-show="show" v-touch="{down: () => $emit('update:show', false)}">
            <v-fade-transition>
                <div id="fullscreen-player-gradient-static" :style="staticGradient" v-show="show">
                    <div :style="animatedGradient1" id="fullscreen-player-gradient-1"></div>
                    <div :style="animatedGradient2" id="fullscreen-player-gradient-2"></div>
                </div>
            </v-fade-transition>
            <v-container class="h-100">
                <div class="fullscreen-player-header">
                    <v-btn text icon @click="$emit('update:show', false)">
                        <v-icon large>keyboard_arrow_down</v-icon>
                    </v-btn>
                    <v-btn text icon>
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </div>
                <v-container class="fullscreen-player-content h-100 pa-4">
                    <div class="mt-5">
                        <v-window class="fullscreen-player-track-window" v-model="activeTrackWindow" v-touch="{down: () => $emit('update:show', false)}">
                            <v-window-item v-for="track in trackList" :key="track.id">
                                <player-image-slide :track="track"></player-image-slide>
                            </v-window-item>
                        </v-window>
                        <div class="fullscreen-player-track-data mt-3">
                            <div class="flex-grow-1">
                                <span class="headline">{{ title }}</span>
                                <br>
                                <span class="subtitle-1">{{ artists }}</span>
                            </div>
                            <v-btn text icon>
                                <v-icon>mdi-dots-vertical</v-icon>
                            </v-btn>
                        </div>
                    </div>
                    <div class="fullscreen-player-controls mb-5">
                        <div>
                            <v-btn text x-large icon aria-label="Play previous" :disabled="noPreviousTrack">
                                <v-icon @click="playPrevious">skip_previous</v-icon>
                            </v-btn>
                            <v-btn x-large fab @click="togglePlay"
                                   :aria-label="playing ? 'Pause' : 'Play'"
                                   class="ml-2 mr-2">
                                <v-icon v-if="playing">pause</v-icon>
                                <v-icon v-else>play_arrow</v-icon>
                            </v-btn>
                            <v-btn text x-large icon aria-label="Play next" :disabled="noNextTrack">
                                <v-icon @click="playNext">skip_next</v-icon>
                            </v-btn>
                        </div>
                        <v-slider hide-details
                                  v-model="progress"
                                  :max="trackDuration || 1"
                                  :disabled="!trackDuration"
                                  color="secondary"
                                  class="fullscreen-player-progress-bar mt-4"></v-slider>
                        <div class="flex-space-between w-100">
                            <div class="caption grey--text">{{ progressFormatted }}</div>
                            <v-rating v-model="rating"
                                      color="secondary"
                                      :size="24"
                                      style="z-index: 10001"
                                      background-color="secondary darken2"
                                      class="mt-3 mb-2"
                                      dense half-increments></v-rating>
                            <div class="caption grey--text">{{ durationFormatted}}</div>
                        </div>
                    </div>
                </v-container>
            </v-container>
        </div>
    </v-expand-transition>
</template>

<script>
    import playerControlsMixin from "$components/components/Player/playerControlsMixin";
    import Vue from 'vue';
    import player from "$store/player/helpers/v2/player";
    import PlayerImageSlide from './PlayerImageSlide';

    export default Vue.extend({
        name: "PlayerFullscreenMobile",
        mixins: [playerControlsMixin],
        components: {PlayerImageSlide},
        props: {
            show: Boolean,
            backgroundColor: {
                type: String,
                default: '50, 175, 170',
                validator: value => value.split(',').length === 3,
            },
            backgroundColorAccent: {
                type: String,
                default: '#0065a8',
            },
        },
        data() {
            return {
                activeTrackWindow: null,
            }
        },
        watch: {
            activeTrackWindow(index) {
                player.playTrackIndex(index);
            },
            'currentTrack.id'() {
                this.activeTrackWindow = player.currentTrackIndex;
            }
        },
        computed: {
            staticGradient() {
                return {
                    background: `linear-gradient(0deg, rgba(0,0,0, 0) 0%, rgba(${this.backgroundColor}, 0.1) 20%, rgba(${this.backgroundColor}, 0.6) 73%, ${this.backgroundColorAccent} 100%)`,
                }
            },
            animatedGradient1() {
                return {
                    background: `linear-gradient(315deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 40%, rgba(${this.backgroundColor}, 0.6) 100%)`,
                }
            },
            animatedGradient2() {
                return {
                    background: `linear-gradient(315deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 40%, ${this.backgroundColorAccent} 100%)`,
                }
            },
            rating: {
                get() {
                    return this.currentTrack ? this.currentTrack.rating : null;
                },
                set(rating) {
                    this.currentTrack.rating = rating;
                    this.$store.dispatch('tracks/rateTrack', {track: this.currentTrack, rating});
                }
            },
            trackList() {
                return player.trackList;
            }
        }
    });
</script>

<style scoped lang="scss">

    .fullscreen-player {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;
        touch-action: none;

        &-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        &-content {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            z-index: 10000;
        }

        &-track-data{
            display: flex;
            justify-content: space-between;
        }

        &-controls {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: auto;
        }

        &-progress-bar {
            width: 100%;
        }
    }

    #fullscreen-player-gradient-static {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        #fullscreen-player-gradient-1, #fullscreen-player-gradient-2 {
            position: absolute;
            top: -50vw;
            left: -50vw;
            width: 200vw;
            height: 160vw;
            animation: gradient-animation infinite ease-in-out;
        }

        #fullscreen-player-gradient-1 {
            -webkit-animation-duration: 7s;
            -moz-animation-duration: 7s;
            -o-animation-duration: 7s;
            animation-duration: 7s;
            -webkit-animation-direction: alternate-reverse;
            -moz-animation-direction: alternate-reverse;
            -o-animation-direction: alternate-reverse;
            animation-direction: alternate-reverse;
        }

        #fullscreen-player-gradient-2 {
            -webkit-animation-duration: 5s;
            -moz-animation-duration: 5s;
            -o-animation-duration: 5s;
            animation-duration: 5s;
            -webkit-animation-direction: alternate;
            -moz-animation-direction: alternate;
            -o-animation-direction: alternate;
            animation-direction: alternate;
        }
    }

    @keyframes gradient-animation {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(95deg);
        }
    }
</style>
