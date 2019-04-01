<template>
    <v-flex>
        <v-layout column>
            <v-flex grow>
                <v-layout justify-center>
                    <v-flex shrink>
                        <v-btn flat icon>
                            <v-icon>skip_previous</v-icon>
                        </v-btn>
                        <v-btn flat icon :loading="loading" @click="togglePlay">
                            <v-icon large class="primary--text" v-if="playing">pause_circle_filled</v-icon>
                            <v-icon large class="primary--text" v-else>play_circle_filled</v-icon>
                        </v-btn>
                        <v-btn flat icon>
                            <v-icon>skip_next</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex class="primary d-flex">
                <v-flex grow class="pa-0 pr-3 text-truncate">
                    <span>{{ title }}</span>
                    <br>
                    <span>{{ artist }}</span>
                </v-flex>
                <v-flex shrink class="pa-0 d-flex align-center" style="flex: 0 !important;">
                    <v-progress-circular :value="progress" ></v-progress-circular>
                </v-flex>
            </v-flex>
        </v-layout>
    </v-flex>
</template>

<script>
    export default {
        name: "PlayerControls",
        methods: {
            togglePlay() {
                if (this.playing) {
                    this.$store.dispatch('player/pause');
                } else {
                    this.$store.dispatch('player/play');
                }
            }
        },
        computed: {
            title() {
                return this.currentTrack ? this.currentTrack.name : 'No track';
            },
            artist() {
                return this.currentTrack ? this.currentTrack.artist.name : '-';
            },
            playing() {
                return this.$store.getters['player/playing'];
            },
            currentTrack() {
                return this.$store.getters['player/playingTrack'];
            },
            loading() {
                return this.$store.getters['player/loading']
            },
            progress() {
                return this.$store.getters['player/progressPercent'];
            }
        }
    }
</script>

<style scoped>
    .track-progress {
        position: absolute;
        right: 12px;
        bottom: 12px
    }
</style>
