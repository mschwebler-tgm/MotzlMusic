<template>
    <div class="pa-3">
        <div class="current-tracks">
            <v-fade-transition>
                <div class="d-flex align-center justify-center h-100" v-if="tracksRaw.length === 0">
                    <span>Start playback to see a list of current tracks</span>
                </div>
                <div v-else>
                    <track-table :tracks="tracksRaw"
                                 :config="tableConfig"
                                 height="360px"></track-table>
                </div>
            </v-fade-transition>
        </div>
    </div>
</template>

<script>
    import TrackTable from "$scripts/components/TrackTable/TrackTable";
    import {columns as desktopColumns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";
    import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";

    export default {
        name: "CurrentTracks",
        components: {TrackTable},
        computed: {
            tracksRaw() {
                return this.$store.getters['player/trackListRaw'];
            },
            currentTrackId() {
                return this.$store.getters['player/currentTrackId'];
            },
            tableConfig() {
                const options = new ClusterizeOptions();
                options.setOptions({
                    desktopColumns: [
                        desktopColumns.TRACK_TITLE,
                        desktopColumns.DURATION,
                        desktopColumns.ARTISTS,
                    ],
                    activeByPlayingTrackListIndex: true,
                    showQueueIndicators: true,
                    contextMenu: false,
                    activatable: true,
                    queueable: false,
                    draggable: false,
                    playable: true,
                    desktop: true,
                });

                return options;
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
