<template>
    <div class="pa-3">
        <div class="current-tracks">
            <v-fade-transition>
                <div class="d-flex align-center justify-center h-100" v-if="tracksRaw.length === 0">
                    <span>Start playback to see a list of current tracks</span>
                </div>
                <div v-else>
                    <div v-for="track in tracksRaw"
                         :key="`${track.trackData.id}_${track.isQueued}`"
                         class="track-row font-weight-light">
                        <div class="playing-icon">
                            <img src="/images/icons/volume_up.png" alt="playing" v-if="currentTrackId === track.trackData.id">
                        </div>
                        <div class="track-title text-truncate">{{ track.trackData.name }}</div>
                        <div class="track-artist text-truncate">{{ track.trackData.artists[0].name }}</div>
                    </div>
                </div>
            </v-fade-transition>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CurrentTracks",
        computed: {
            tracksRaw() {
                return this.$store.getters['player/trackListRaw'];
            },
            currentTrackId() {
                return this.$store.getters['player/currentTrackId'];
            }
        },
    }
</script>

<style scoped lang="scss">
    .current-tracks {
        height: 360px;
        overflow-y: scroll;

        &::-webkit-scrollbar {
            display: none;
        }

        .track-row {
            display: flex;

            &:nth-child(odd) {
                background-color: rgba(255, 255, 255, 0.04);
            }

            &:hover {
                background-color: rgba(255, 255, 255, 0.11);
            }

            .playing-icon {
                width: 25px;
                display: flex;
                align-items: center;
                justify-content: center;

                > img {
                    filter: invert(100%);
                }
            }

            .track-title {
                flex: 1;
                padding-left: 3px;
                padding-right: 15px;
            }

            .track-artist {
                width: 150px;
            }
        }
    }
</style>
