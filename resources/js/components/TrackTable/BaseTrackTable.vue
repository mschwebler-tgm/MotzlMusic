<template>
    <div class="track-table">
        <div :id="tableId"
             :style="{'max-height': scrollContainerHeight}"
             class="clusterize-scroll"
             ref="scrollArea">
            <div :id="identifier + '-contentArea'"
                 class="clusterize-content"
                 @focusin="onTrackFocus"
                 @focusout="resetTrackFocus"
                 @keydown.down.prevent="onKeyDown"
                 @keydown.up.prevent="onKeyUp">
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
        <track-table-context-menu :table-id="tableId" ref="contextMenu"></track-table-context-menu>
    </div>
</template>

<script>
    import Clusterize from "clusterize.js";
    import TrackTableContextMenu from "./TrackTableContextMenu";
    import handleMutations from './StoreWatchers';
    import StarRating from "../_BaseComponents/StarRating";

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
                touchDragging: false,
            }
        },
        mounted() {
            if (!this.isInitialized) {
                this.initializeTracksTable();
            }
            this.initDoubleClickListener();
            this.initStoreWatchers();
        },
        watch: {
            tracks() {
                this.initializeTracksTable();
            },
        },
        methods: {
            onTrackFocus($event) {
                const track = this.getTrackFromDomElement($event.target);
                this.$store.commit('subContent/setFocusedItems', [track]);
            },
            resetTrackFocus() {
                this.$store.commit('subContent/setFocusedItems', []);
            },
            initializeTracksTable() {
                this.isInitialized = true;
                this.clusterize = new Clusterize({
                    scrollId: this.tableId,
                    contentId: this.identifier + '-contentArea',
                    rows: this.renderFunction(this.tracks, this.playingTrackId),
                    callbacks: {
                        clusterChanged: () => this.clusterChanged()
                    }
                });
            },
            clusterChanged() {
                this.initStarRatings();
            },
            playTrack(track) {
                this.$store.dispatch('player/play', track);
                this.$store.commit('player/setQueue', this.tracks);
                this.$store.commit('player/setQueueTrack', track);
            },
            initDoubleClickListener() {
                const playTrack = $event => {
                    const trackElement = this.findTrackElement($event.target);
                    const track = this.getTrackFromDomElement(trackElement);
                    this.playTrack(track);
                };
                this.$refs.scrollArea.addEventListener('dblclick', playTrack);
                this.$refs.scrollArea.addEventListener('touchend', $event => {
                    if (!this.touchDragging && !this.$refs.contextMenu.show && !$event.target.classList.contains('track-options')) {
                        playTrack($event)
                    }
                });
                this.$refs.scrollArea.addEventListener('touchstart', () => this.touchDragging = false);
                this.$refs.scrollArea.addEventListener('touchmove', () => this.touchDragging = true);
            },
            findTrackElement(element) {
                return element.classList.contains('track') ? element : this.findTrackElement(element.parentElement);
            },
            findElementByTrackId(id) {
                return this.$refs.scrollArea.querySelector(`[data-id="${id}"]`);
            },
            getTrackFromDomElement(trackElement) {
                const trackId = trackElement.getAttribute('data-id');
                return this.tracks.filter(track => track.id === parseInt(trackId))[0];
            },
            onKeyDown() {
                const nextTrackElement = document.activeElement.nextElementSibling;
                if (nextTrackElement) {
                    nextTrackElement.focus();
                }
            },
            onKeyUp() {
                const previousTrackElement = document.activeElement.previousElementSibling;
                if (previousTrackElement) {
                    previousTrackElement.focus();
                }
            },
            initStoreWatchers() {
                this.$store.subscribe((mutation, state) => handleMutations.apply(this, [mutation, state]));
            },
            initStarRatings() {
                const self = this;
                this.$refs.scrollArea.querySelectorAll(`.track-list-rating`).forEach(element => {
                    let selectedRating = 0;
                    const mouseEnter = $event => {
                        const starWrapperElement = $event.target;
                        const track = self.getTrackFromDomElement(starWrapperElement.parentNode);
                        const starRating = new StarRating(starWrapperElement);
                        element.removeEventListener('mouseenter', mouseEnter);
                        starRating.onRateHover(amount => starWrapperElement.innerHTML = StarRating.getStarSVGs(amount, true).join(''));
                        starRating.onRate(amount => {
                            selectedRating = amount;
                            self.$store.dispatch('tracks/rateTrack', {track, rating: amount})
                        });
                    };

                    element.addEventListener('mouseenter', mouseEnter);
                    element.addEventListener('mouseleave', $event => {
                        const starWrapperElement = $event.target;
                        const track = this.getTrackFromDomElement(starWrapperElement.parentNode);
                        starWrapperElement.innerHTML = StarRating.getStarSVGs(selectedRating || track.rating).join('')
                    });
                })
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
