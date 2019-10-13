<template>
    <div class="base-track-table">
        <div :id="scrollId"
             class="clusterize-scroll">
            <div :id="contentId"
                 class="clusterize-content" @focusin="trackGotFocus">
            </div>
        </div>
    </div>
</template>

<script>
    import Clusterize from "clusterize.js";
    import DesktopClusterizer from "$scripts/components/TrackTable/Clusterizer/Desktop/DesktopClusterizer";
    import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";

    export default {
        name: "BaseTrackTable2",
        props: {
            tracks: Array,
            options: {
                type: ClusterizeOptions,
                default: () => new ClusterizeOptions(),
            },
        },
        data() {
            return {
                tableId: 'table' + Math.random().toString(36).substring(7),
                clusterizer: null,
            }
        },
        created() {
            this.clusterizer = new DesktopClusterizer(this.options);
        },
        mounted() {
            this.initializeTracksTable();
        },
        methods: {
            initializeTracksTable() {
                const rows = this.clusterizer.generateForTracks(this.tracks);
                this._initClusterizeJs(rows);
            },
            _initClusterizeJs(rows) {
                new Clusterize({
                    scrollId: this.scrollId,
                    contentId: this.contentId,
                    rows,
                    callbacks: {
                        // clusterChanged: () => this.clusterChanged()
                    }
                });
            },
            trackGotFocus($event) {
                const trackId = $event.target.dataset.id;
                if (!trackId) {
                    return;
                }

                const focusedTrack = this.tracks.filter(track => track.id === trackId)[0];
                this.$emit('track-selected', focusedTrack);
            }
        },
        computed: {
            scrollId() {
                return this.tableId + '-scroll';
            },
            contentId() {
                return this.tableId + '-content';
            },
        }
    }
</script>

<style lang="scss">
    $row-height: 40px;

    .base-track-table {

        .track-row {
            height: $row-height;
            display: flex;
            align-items: center;
            overflow: hidden;

            &:focus {
                background-color: var(--v-primary-lighten1) !important;
                outline: none;
            }

            > div {
                padding-left: 5px;
                padding-right: 5px;
            }

            &:nth-child(odd) {
                background-color: rgba(255, 255, 255, 0.04);
            }

            &:hover {
                background-color: rgba(255, 255, 255, 0.11);
            }

            &-number {
                width: 40px;
                text-align: right;

                &::after {
                    content: '.';
                }
            }

            &-title {
                width: 300px;
            }

            &-album {
            }

            &-image {
                width: $row-height;
                height: $row-height;
                padding: 2px !important;

                > img {
                    width: 100%;
                    height: 100%;
                }
            }

            &-artist {
                width: 250px;
                opacity: .5;
                cursor: pointer;

                &:hover {
                    text-decoration: underline;
                }
            }

            &-duration {
                width: 42px;
            }

            &-rating {
                width: 200px;
            }

            &-info-icons {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            &-options {
                -webkit-transition: .1s ease-in-out;
                -moz-transition: .1s ease-in-out;
                -ms-transition: .1s ease-in-out;
                -o-transition: .1s ease-in-out;
                transition: .1s ease-in-out;
                width: 0;
            }

            .track-row-info-icons:hover ~ .track-row-options, .track-row-options:hover {
                width: 40px;
            }
        }
    }
</style>
