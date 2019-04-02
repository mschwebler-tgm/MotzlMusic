<template>
    <v-flex class="track-table" id="my-library-tracks-table">
        <div :id="identifier + '-scrollArea'"
             :style="{'max-height': scrollContainerHeight}"
             class="clusterize-scroll"
             ref="scrollArea">
            <div :id="identifier + '-contentArea'" class="clusterize-content">
                <tr class="clusterize-no-data">
                </tr>
            </div>
        </div>
        <div class="d-flex justify-center" v-if="showLoading">
            <v-progress-circular
                    color="accent"
                    indeterminate>
            </v-progress-circular>
        </div>
    </v-flex>
</template>

<script>
    import Clusterize from "clusterize.js";

    export default {
        name: "BaseTrackTable",
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
            }
        },
        mounted() {
            if (!this.isInitialized) {
                this.initializeTracksTable();
            }
            this.initDoubleClickListener();
        },
        watch: {
            tracks() {
                this.initializeTracksTable();
            },
            playingTrackId(trackId, oldTrackId) {
                this.setActiveClassFor(trackId, oldTrackId);
            }
        },
        methods: {
            initializeTracksTable() {
                this.isInitialized = true;
                this.clusterize = new Clusterize({
                    scrollId: this.identifier + '-scrollArea',
                    contentId: this.identifier + '-contentArea',
                    rows: this.renderFunction(this.tracks, this.playingTrackId),
                });
                this.setAlreadyActiveTrackElement();
            },
            initDoubleClickListener() {
                const findTrackElement = element => element.classList.contains('track') ? element : findTrackElement(element.parentElement);
                document.getElementById(this.identifier + '-contentArea').addEventListener('dblclick', event => {
                    const trackElement = findTrackElement(event.target);
                    const trackId = trackElement.getAttribute('data-id');
                    const track = this.tracks.filter(track => track.id === parseInt(trackId))[0];
                    this.toggleActiveClass(trackElement);
                    this.$emit('track-selected', track);
                });
            },
            toggleActiveClass(element) {
                if (this.activeTrackElement) {
                    this.activeTrackElement.classList.remove('active');
                }
                element.classList.add('active');
                this.activeTrackElement = element;
            },
            setAlreadyActiveTrackElement() {
                const alreadyActiveTrackElement = document.getElementsByClassName('track active');
                if (alreadyActiveTrackElement.length) {
                    this.activeTrackElement = alreadyActiveTrackElement[0];
                }
            },
            setActiveClassFor(trackId) {
                const elements = this.$refs.scrollArea.querySelectorAll(`[data-id='${trackId}']`);
                if (elements.length > 0) {
                    this.toggleActiveClass(elements[0]);
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
            }
        }
    }
</script>

<style lang="scss">
    @import "../../sass/components/_trackTable";
</style>
