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
            <v-container fluid class="pt-0 pb-0">
                <v-layout row wrap class="h-100">
                    <v-flex xs9 class="flex-center">
                        <span class="subtitle-2">{{ title }}</span>
                        <span class="grey--text">&nbsp;&nbsp;-&nbsp;&nbsp;</span>
                        <span class="body-2">{{ artists }}</span>
                    </v-flex>
                    <v-flex xs3 class="flex-center">
<!--                        Subcontent-->
                    </v-flex>
                </v-layout>
            </v-container>
        </div>
        <spotify-player></spotify-player>
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
        }
    });
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

            .player-controls {
                min-width: 256px;
                display: flex;
                justify-content: center;
            }
        }
    }
</style>
