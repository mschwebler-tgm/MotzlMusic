<template>
    <div>
        <span class="headline">Tracks</span>
        <v-container>
            <div class="h-100 clusterize flex-column">
                <div class="flex-1 track-table" id="my-library-tracks-table">
                    <div :id="identifier + '-scrollArea'" class="clusterize-scroll" :style="{'max-height': scrollContainerHeight}" ref="scrollArea">
                        <div :id="identifier + '-contentArea'" class="clusterize-content">
                            <tr class="clusterize-no-data">
                                <v-progress-circular
                                        v-if="!$parent.tracksInitialized"
                                        color="primary"
                                        indeterminate>
                                </v-progress-circular>
                            </tr>
                        </div>
                    </div>
                </div>
            </div>
        </v-container>
    </div>
</template>

<script>
    import Clusterize from "clusterize.js";

    export default {
        name: "Tracks",
        data() {
            return {
                clusterize: null,
                scrollContainerHeight: '746px',
                identifier: Math.random().toString(36).substring(7)
            }
        },
        created() {
            this.initResizeWatcher();
        },
        mounted() {
            const vue = this;
            $('#my-library-tracks-table').on('dblclick', '.track', function () {
                const trackId = parseInt(this.dataset.id);
                const track = vue.tracks.find(track => track.id === trackId);
                vue.$store.dispatch('player/play', track);
            });
            this.initializeTracksTable();
        },
        methods: {
            initializeTracksTable() {
                const clusterize = _ => {
                    console.log('clusterize it!');
                    this.clusterize = new Clusterize({
                        scrollId: this.identifier + '-scrollArea',
                        contentId: this.identifier + '-contentArea',
                        rows: this.tracksDomElements
                    });
                };
                if (!this.$store.getters['myLibrary/tracksInitialized']) {
                    const unwatch = this.$store.watch((state, getters) => getters['myLibrary/tracksInitialized'], _ => {
                        clusterize();
                        unwatch();
                    });
                } else {
                    clusterize();
                }
            },
            initResizeWatcher() {
                const resizeDone = originalHeight => {
                    if (originalHeight > window.innerHeight) {
                        // TODO refresh clusterize.js
                    }
                };
                let resizeTimeout;
                const originalHeight = window.innerHeight;
                window.onresize = function(){
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(_ => resizeDone(originalHeight), 100);
                };
            }
        },
        computed: {
            tracks() {
                return this.$store.getters['myLibrary/tracks'];
            },
            tracksDomElements() {
                return this.$store.getters['myLibrary/tracksClusterized'];
            }
        }
    }
</script>

<style lang="scss">
    @import "../../../../sass/components/trackTable";
</style>