<template>
    <div class="base-track-table">
        <div :id="scrollId"
             class="clusterize-scroll">
            <div :id="contentId"
                 ref="contentArea"
                 class="clusterize-content"
                 @focusin="trackGotFocus"
                 @keydown.down.prevent="focusNextTrack"
                 @keydown.up.prevent="focusPreviousTrack"
                 @keydown.enter="playTrackFromEvent"
                 @contextmenu.prevent="showContextMenu">
            </div>
        </div>
        <v-menu v-model="contextMenu.show"
                :position-x="contextMenu.positionX"
                :position-y="contextMenu.positionY"
                v-if="options.is('desktop')"
                offset-x
                absolute>
            <v-list light dense>
                <v-list-item @click="queueTrack">
                    <v-list-item-icon>
                        <v-icon small>add_to_queue</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        Add to Queue
                    </v-list-item-title>
                </v-list-item>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon small>playlist_add</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        Add to Playlist
                    </v-list-item-title>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon small>delete</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        Remove from your Library
                    </v-list-item-title>
                </v-list-item>
                <v-list-item>
                    <v-list-item-icon>
                        <v-icon small>edit</v-icon>
                    </v-list-item-icon>
                    <v-list-item-title>
                        Edit
                    </v-list-item-title>
                </v-list-item>
            </v-list>
        </v-menu>
    </div>
</template>

<script>
    import Clusterize from "clusterize.js";
    import DesktopClusterizer from "$scripts/components/TrackTable/Clusterizer/Desktop/DesktopClusterizer";
    import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";
    import {RenderDesktopColumns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";
    import StarRating from "$scripts/components/_BaseComponents/StarRating";
    import hotkeys from "hotkeys-js";
    import {shortcuts} from "$scripts/helpers/shortcuts";

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
                contextMenu: {
                    show: false,
                    positionX: 0,
                    positionY: 0,
                    track: null,
                }
            }
        },
        created() {
            this.clusterizer = new DesktopClusterizer(this.options);
        },
        mounted() {
            this.initializeTracksTable();
            if (this.options.is('playable')) {
                this.initPlayListeners();
            }
            if (this.options.is('queueable')) {
                this.initQueueListener();
            }
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
                        clusterChanged: () => this.clusterChanged()
                    }
                });
            },
            trackGotFocus($event) {
                const trackId = $event.target.dataset.id;
                if (!trackId) {
                    return;
                }

                const focusedTrack = this._getTrackById(trackId);
                this.$emit('track-selected', RenderDesktopColumns.getTrackData(focusedTrack));
            },
            focusNextTrack() {
                let nextTrackElement = document.activeElement.nextElementSibling;
                if (this.contentAreaIsFocused()) {
                    const firstTrack = RenderDesktopColumns.getTrackData(this.tracks[0]);
                    nextTrackElement = this.$refs.contentArea.querySelector(`[data-id="${firstTrack.id}"]`);
                }
                this.focusTrackRow(nextTrackElement);
            },
            focusPreviousTrack() {
                let previousTrackElement = document.activeElement.previousElementSibling;
                this.focusTrackRow(previousTrackElement);
            },
            focusTrackRow(trackElement) {
                if (trackElement) {
                    trackElement.focus();
                }
            },
            contentAreaIsFocused() {
                return this.$refs.contentArea === document.activeElement;
            },
            initPlayListeners() {
                if (this.options.is('desktop')) {
                    this.$refs.contentArea.addEventListener('dblclick', $event => this.playTrackFromEvent($event));
                }
            },
            playTrackFromEvent($event) {
                if (this.options.is('playable')) {
                    const track = RenderDesktopColumns.getTrackData(this._getTrackFromEvent($event))
                    this.$emit('play-track', track);
                }
            },
            _getTrackFromEvent($event) {
                let trackId = null;
                for (let i = 0; i < $event.path.length; i++) {
                    if ($event.path[i].classList.contains('track-row')) {
                        trackId = parseInt($event.path[i].dataset.id);
                        break;
                    }
                }

                return this._getTrackById(trackId);
            },
            _getTrackById(trackId) {
                trackId = parseInt(trackId);
                return this.tracks.filter(track => RenderDesktopColumns.getTrackData(track).id === trackId)[0];
            },
            clusterChanged() {
                this.initStarRatings();
                if (this.options.is('contextMenu')) {
                    this.initContextMenuListener();
                }
            },
            initStarRatings() {
                const self = this;
                this.$refs.contentArea.querySelectorAll(`.track-row-rating`).forEach(element => {
                    let selectedRating = 0;
                    const mouseEnter = $event => {
                        const starWrapperElement = $event.target;
                        const track = RenderDesktopColumns.getTrackData(self._getTrackFromEvent($event));
                        const starRating = new StarRating(starWrapperElement);
                        element.removeEventListener('mouseenter', mouseEnter);
                        starRating.onRateHover(amount => starWrapperElement.innerHTML = StarRating.getStarSVGs(amount, true).join(''));
                        starRating.onRate(amount => {
                            selectedRating = amount;
                            self.$emit('rate-track', track, amount);
                        });
                    };

                    element.addEventListener('mouseenter', mouseEnter);
                    element.addEventListener('mouseleave', $event => {
                        const starWrapperElement = $event.target;
                        const track = RenderDesktopColumns.getTrackData(self._getTrackFromEvent($event));
                        starWrapperElement.innerHTML = StarRating.getStarSVGs(selectedRating || track.rating).join('')
                    });
                })
            },
            initQueueListener() {
                hotkeys(shortcuts.QUEUE_NEXT, $event => {
                    const track = RenderDesktopColumns.getTrackData(this._getTrackFromEvent($event));
                    this.$emit('queue-track', track);
                });
            },
            initContextMenuListener() {
                this.$refs.contentArea.querySelectorAll('.track-row-options').forEach(element => {
                    element.addEventListener('click', $event => this.showContextMenu($event));
                });
            },
            showContextMenu($event) {
                if (this.options.is('contextMenu')) {
                    this.contextMenu.positionX = $event.clientX;
                    this.contextMenu.positionY = $event.clientY;
                    this.contextMenu.show = true;
                    this.contextMenu.track = this._getTrackFromEvent($event);
                }
            },
            queueTrack() {
                this.$emit('queue-track', RenderDesktopColumns.getTrackData(this.contextMenu.track));
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
                display: flex;
                align-items: center;

                &-queue-indicator {
                    font-size: .7em;
                    border: 1px solid;
                    width: 1.5em;
                    height: 1.5em;
                    line-height: 1em;
                    text-align: center;
                    padding: .2em;
                    -webkit-border-radius: 5px;
                    -moz-border-radius: 5px;
                    border-radius: 5px;
                    margin-left: 5px;
                    opacity: .5;
                }
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
                width: 130px;
                height: 100%;
                display: flex;
                align-items: center;
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
