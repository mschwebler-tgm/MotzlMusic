<template>
    <v-flex>
        <v-layout column>
            <v-flex grow>
                <v-layout justify-center>
                    <v-flex shrink>
                        <v-btn flat icon>
                            <v-icon @click="playPrevious">skip_previous</v-icon>
                        </v-btn>
                        <v-btn flat icon :loading="loading" @click="togglePlay">
                            <v-icon large class="secondary--text" v-if="playing">pause_circle_filled</v-icon>
                            <v-icon large class="secondary--text" v-else>play_circle_filled</v-icon>
                        </v-btn>
                        <v-btn flat icon>
                            <v-icon @click="playNext">skip_next</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex class="secondary d-flex gradient">
                <v-flex grow class="pa-0 pr-3 text-truncate">
                    <span class="body-2">{{ title }}</span>
                    <br>
                    <span class="caption">{{ artist }}</span>
                </v-flex>
                <v-flex shrink class="pa-0 d-flex align-center" style="flex: 0 !important;">
                    <v-progress-circular :value="progress"></v-progress-circular>
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
            },
            playNext() {
                const track = this.queueController.playNext();
                this.$store.dispatch('player/play', track);
            },
            playPrevious() {
                const track = this.queueController.playPrevious();
                this.$store.dispatch('player/play', track);
            },
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
            },
            queueController() {
                return this.$store.getters['player/queueController'];
            },
        }
    }
</script>

<style scoped>
    .track-progress {
        position: absolute;
        right: 12px;
        bottom: 12px
    }

    .gradient {
        background: -moz-linear-gradient(-90deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.20) 100%);
        background: -webkit-linear-gradient(-90deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.20) 100%);
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.20) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#54000000', GradientType=1);
    }

</style>
