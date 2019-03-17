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
        name: "TrackTable",
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
            }
        },
        mounted() {
            if (!this.isInitialized) {
                this.initializeTracksTable();
            }
        },
        watch: {
            tracks() {
                this.initializeTracksTable();
            }
        },
        methods: {
            initializeTracksTable() {
                this.isInitialized = true;
                this.clusterize = new Clusterize({
                    scrollId: this.identifier + '-scrollArea',
                    contentId: this.identifier + '-contentArea',
                    rows: this.renderFunction(this.tracks),
                });
            },
        },
        computed: {
            showLoading() {
                return this.tracks.length === 0 || !this.isInitialized;
            }
        }
    }
</script>

<style lang="scss">
    @import "../../sass/components/_trackTable";
</style>
