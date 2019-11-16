<template>
    <div class="base-track-table">
        <div v-if="showLoading">
            <v-skeleton-loader type="list-item-avatar-two-line"></v-skeleton-loader>
            <v-skeleton-loader type="list-item-avatar-two-line"></v-skeleton-loader>
            <v-skeleton-loader type="list-item-avatar-two-line"></v-skeleton-loader>
            <v-skeleton-loader type="list-item-avatar-two-line"></v-skeleton-loader>
            <v-skeleton-loader type="list-item-avatar-two-line"></v-skeleton-loader>
            <v-skeleton-loader type="list-item-avatar-two-line"></v-skeleton-loader>
        </div>
        <div :id="scrollId"
             :style="{'max-height': height}"
             class="clusterize-scroll">
            <div :id="contentId"
                 ref="contentArea"
                 class="clusterize-content"
                 @focusin="trackGotFocus"
                 @keydown.down.prevent="focusNextTrack"
                 @keydown.up.prevent="focusPreviousTrack"
                 @keydown.enter="playTrackFromEvent"
                 @contextmenu.prevent="showContextMenu"
                 v-on="$listeners">
            </div>
        </div>
        <component v-model="contextMenu.show"
                   :position-x="contextMenu.positionX"
                   :position-y="contextMenu.positionY"
                   :is="menuComponent"
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
        </component>
    </div>
</template>

<script>
    import Clusterize from "clusterize.js";
    import DesktopClusterizer from "$scripts/components/TrackTable/Clusterizer/Desktop/DesktopClusterizer";
    import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";
    import StarRating from "$scripts/components/_BaseComponents/StarRating";
    import hotkeys from "hotkeys-js";
    import {shortcuts} from "$scripts/helpers/shortcuts";
    import MobileClusterizer from "$scripts/components/TrackTable/Clusterizer/Mobile/MobileClusterizer";

    export default {
        name: "BaseTrackTable2",
        props: {
            tracks: Array,
            options: {
                type: ClusterizeOptions,
                default: () => new ClusterizeOptions(),
            },
            height: {
                type: String,
                default: '500px',
            }
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
                },
                touchDragging: false,
                activeTrackRowElement: null,
                isInitialized: false,
            }
        },
        created() {
            if (this.options.is('desktop')) {
                this.clusterizer = new DesktopClusterizer(this.options);
            } else {
                this.clusterizer = new MobileClusterizer(this.options);
            }
        },
        watch: {
            tracks() {
                this.initializeTracksTable();
            },
            currentTrackId(trackId) {
                if (!trackId) {
                    return;
                }
                this.setActiveClass();
            },
            queuedTracksRaw(newTracks, oldQueuedTracks) {
                if (this.options.is('showQueueIndicators')) {
                    const queuedTrackElements = this.$refs.contentArea.querySelectorAll('.track-row.queued');
                    queuedTrackElements.forEach(element => {
                        const trackId = parseInt(element.dataset.id);
                        const titleElement = element.querySelector('.track-row-title');
                        const track = oldQueuedTracks.find(rawTrack => rawTrack.trackData.id === trackId);
                        if (track) {
                            titleElement.outerHTML = this.clusterizer.columnRenderClass.trackTitle(track, this.options);
                        }
                    });
                }
            }
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
            clusterChanged() {
                this.isInitialized = true;
                this.initStarRatings();
                this.setActiveClass();
                if (this.options.is('contextMenu')) {
                    this.initContextMenuListener();
                }
                if (this.options.is('draggable')) {
                    // TODO init draggable
                    // this.dragContainer = smoothDnD(this.$refs.contentArea, this.options.get('draggableOptions'));
                }
                this.$emit('clusterChanged');
            },
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
                        clusterChanged: () => this.clusterChanged(),
                    }
                });
            },
            setActiveClass() {
                if (this.activeTrackRowElement) {
                    this.activeTrackRowElement.classList.remove('active');
                }
                if (this.options.is('activeByPlayingTrackListIndex')) {
                    this.activeTrackRowElement = this.$refs.contentArea.querySelectorAll('.track-row')[this.currentTrackIndex];
                } else {
                    this.activeTrackRowElement = this.$refs.contentArea.querySelector(`[data-id="${this.currentTrackId}"]`);
                }
                if (this.activeTrackRowElement) {
                    this.activeTrackRowElement.classList.add('active');
                }
            },
            trackGotFocus($event) {
                const trackId = $event.target.dataset.id;
                if (!trackId) {
                    return;
                }

                const focusedTrack = this._getTrackById(trackId);
                this.$emit('select-track', this._getTrackData(focusedTrack));
            },
            focusNextTrack() {
                let nextTrackElement = document.activeElement.nextElementSibling;
                if (this.contentAreaIsFocused()) {
                    const firstTrack = this._getTrackData(this.tracks[0]);
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
                } else {
                    this.$refs.contentArea.addEventListener('touchend', $event => {
                        if (!this.touchDragging && !this.contextMenu.show && !$event.target.classList.contains('track-row-options-mobile')) {
                            this.playTrackFromEvent($event)
                        }
                    });
                    this.$refs.contentArea.addEventListener('touchstart', () => this.touchDragging = false);
                    this.$refs.contentArea.addEventListener('touchmove', () => this.touchDragging = true);
                }
            },
            playTrackFromEvent($event) {
                if (this.options.is('playable')) {
                    const track = this._getTrackData(this._getTrackFromEvent($event));
                    this.$emit('play-track', track);
                }
            },
            _getTrackData(track) {
                return this.clusterizer.columnRenderClass.getTrackData(track);
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
                return this.tracks.find(track => this._getTrackData(track).id === trackId);
            },
            initStarRatings() {
                const self = this;
                this.$refs.contentArea.querySelectorAll(`.track-row-rating`).forEach(element => {
                    let selectedRating = 0;
                    const mouseEnter = $event => {
                        const starWrapperElement = $event.target;
                        const track = this._getTrackData(self._getTrackFromEvent($event));
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
                        const track = this._getTrackData(self._getTrackFromEvent($event));
                        starWrapperElement.innerHTML = StarRating.getStarSVGs(selectedRating || track.rating).join('')
                    });
                })
            },
            initQueueListener() {
                hotkeys(shortcuts.QUEUE_NEXT, $event => {
                    const track = this._getTrackData(this._getTrackFromEvent($event));
                    this.$emit('queue-track', track);
                });
            },
            initContextMenuListener() {
                this.$refs.contentArea.querySelectorAll('.track-row-options').forEach(element => {
                    element.addEventListener('click', $event => this.showContextMenu($event));
                });
                this.$refs.contentArea.querySelectorAll('.track-row-options-mobile').forEach(element => {
                    element.addEventListener('touchend', $event => {
                        $event.stopPropagation();
                        $event.preventDefault();
                        this.showContextMenu($event)
                    });
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
                this.contextMenu.show = false;
                this.$emit('queue-track', this._getTrackData(this.contextMenu.track));
            }
        },
        computed: {
            scrollId() {
                return this.tableId + '-scroll';
            },
            contentId() {
                return this.tableId + '-content';
            },
            menuComponent() {
                return this.options.is('desktop') ? 'v-menu' : 'v-bottom-sheet';
            },
            currentTrackId() {
                return this.$store.getters['player/currentTrackId'];
            },
            queuedTracksRaw() {
                return this.$store.getters['player/queuedTracksRaw'];
            },
            currentTrackIndex() {
                return this.$store.getters['player/currentTrackIndex'];
            },
            showLoading() {
                return this.tracks.length === 0 || !this.isInitialized;
            },
        }
    }
</script>

<style lang="scss">
    $desktop-row-height: 40px;
    $mobile-row-height: 50px;

    .base-track-table {

        .clusterize-scroll {
            overflow-y: scroll;


            &::-webkit-scrollbar {
                background: transparent;
                width: 7px;
            }

            &::-webkit-scrollbar-button {
                display: none;
            }

            &::-webkit-scrollbar-thumb {
                background: rgba(127, 127, 127, 0.5);
            }
        }

        .text-truncate {
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        .track-row {
            height: $desktop-row-height;
            display: flex;
            align-items: center;
            overflow: hidden;

            &:focus {
                background-color: var(--v-primary-lighten1) !important;
                outline: none;
            }

            &.active {
                background-color: var(--v-primary-base) !important;
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

            &.playable {
                cursor: default;
            }

            &-number {
                width: 42px;
                text-align: center;

                &::after {
                    content: '.';
                }
            }

            &.mobile {
                height: $mobile-row-height !important;

                .track-row-title-and-artist {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: flex-start;

                    .track-row-title {
                        width: 100%;
                        font-size: 16px;
                    }

                    .track-row-artist {
                        width: 100%;
                        font-size: .75rem;
                        font-weight: 100 !important;
                    }

                    /*display: flex;*/
                }

                .track-row-image {
                    width: $mobile-row-height;
                    height: $mobile-row-height;
                    padding: 4px !important;

                    > img {
                        width: 100%;
                        height: 100%;
                    }
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
                width: $desktop-row-height;
                height: $desktop-row-height;
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
