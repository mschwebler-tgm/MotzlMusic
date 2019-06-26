<template>
    <v-flex class="track-table" id="my-library-tracks-table">
        <div :id="tableId"
             :style="{'max-height': scrollContainerHeight}"
             class="clusterize-scroll"
             ref="scrollArea">
            <div :id="identifier + '-contentArea'" class="clusterize-content">
                <div class="clusterize-no-data">
                </div>
            </div>
        </div>
        <div class="d-flex justify-center" v-if="showLoading">
            <v-progress-circular
                    color="accent"
                    indeterminate>
            </v-progress-circular>
        </div>
        <track-table-context-menu v-if="!$root.isTouch"
                                          component="v-menu"
                                          :dense="true"
                                          :show.sync="showOptionMenu"
                                          :position-x="optionMenuPositionX"
                                          :position-y="optionMenuPositionY"
                                          :track="rightClickedTrack"></track-table-context-menu>
        <track-table-context-menu v-else
                                  component="v-bottom-sheet"
                                  :show.sync="showOptionMenu"
                                  :track="rightClickedTrack"></track-table-context-menu>
    </v-flex>
</template>

<script>
    import Clusterize from "clusterize.js";
    import TrackTableContextMenu from "./TrackTableContextMenu";

    export default {
        name: "BaseTrackTable",
        components: {TrackTableContextMenu},
        props: {
            tracks: Array,
            renderFunction: Function,
            height: String,
        },
        data() {
            return {
                identifier: Math.random().toString(36).substring(7),
                scrollContainerHeight: this.height || '500px',
                isInitialized: false,
                activeTrackElement: null,
                showOptionMenu: false,
                optionMenuPositionX: 0,
                optionMenuPositionY: 0,
                rightClickedTrack: null,
            }
        },
        mounted() {
            if (!this.isInitialized) {
                this.initializeTracksTable();
            }
            this.initDoubleClickListener();
            this.initMenuListener();
            this.initTouchMenuListener();
        },
        watch: {
            tracks() {
                this.initializeTracksTable();
            },
            playingTrackId(trackId) {
                this.setActiveClassFor(trackId);
            }
        },
        methods: {
            initializeTracksTable() {
                this.isInitialized = true;
                this.clusterize = new Clusterize({
                    scrollId: this.tableId,
                    contentId: this.identifier + '-contentArea',
                    rows: this.renderFunction(this.tracks, this.playingTrackId),
                });
                this.setActiveClassFor(this.playingTrackId);
            },
            initDoubleClickListener() {
                document.getElementById(this.identifier + '-contentArea').addEventListener('dblclick', event => {
                    const trackElement = this.findTrackElement(event.target);
                    const track = this.getTrackFromDomElement(trackElement);
                    this.toggleActiveClass(trackElement);
                    this.$emit('track-selected', track);
                });
            },
            findTrackElement(element) {
                return element.classList.contains('track') ? element : this.findTrackElement(element.parentElement);
            },
            getTrackFromDomElement(trackElement) {
                const trackId = trackElement.getAttribute('data-id');
                return this.tracks.filter(track => track.id === parseInt(trackId))[0];
            },
            toggleActiveClass(element) {
                if (this.activeTrackElement) {
                    this.activeTrackElement.classList.remove('active');
                }
                element.classList.add('active');
                this.activeTrackElement = element;
            },
            setActiveClassFor(trackId) {
                const elements = this.$refs.scrollArea.querySelectorAll(`[data-id='${trackId}']`);
                if (elements.length > 0) {
                    this.toggleActiveClass(elements[0]);
                }
            },
            initMenuListener() {
                const table = document.getElementById(this.tableId);
                table.addEventListener('contextmenu', $event => this.handleTrackOptionsClick($event));
                table.addEventListener('click', $event => {
                    if ($event.target.classList.contains('track-options')) {
                        this.handleTrackOptionsClick($event);
                    }
                })
            },
            handleTrackOptionsClick($event) {
                $event.preventDefault();
                const trackElement = this.findTrackElement($event.target);
                this.rightClickedTrack = this.getTrackFromDomElement(trackElement);
                this.optionMenuPositionX = $event.clientX;
                this.optionMenuPositionY = $event.clientY;
                this.showOptionMenu = true;
            },
            initTouchMenuListener() {
                const onLongTouch = ($event) => {
                    this.handleTrackOptionsClick($event);
                    this.vibrateDevice(100);
                };
                let timer;
                let touchDuration = 500;
                const table = document.getElementById(this.tableId);
                table.addEventListener('touchstart', $event => timer = setTimeout(() => onLongTouch($event), touchDuration));
                table.addEventListener('touchend', () => timer && clearTimeout(timer));
            },
            vibrateDevice(durationMs) {
                if (navigator.vibrate) {
                    navigator.vibrate(durationMs);
                }
            }
        },
        computed: {
            showLoading() {
                return this.tracks.length === 0 || !this.isInitialized;
            },
            playerController() {
                return this.$store.getters['player/controller'];
            },
            playingTrackId() {
                const playingTrack = this.$store.getters['player/playingTrack'];
                return playingTrack ? playingTrack.id : null;
            },
            tableId() {
                return this.identifier + '-scrollArea';
            }
        }
    }
</script>

<style lang="scss">
    @import "../../../sass/components/_trackTable";
</style>
