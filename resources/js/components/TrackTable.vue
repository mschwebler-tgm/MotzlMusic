<template>
    <v-flex class="track-table" id="my-library-tracks-table">
        <div :id="identifier + '-scrollArea'" class="clusterize-scroll" :style="{'max-height': scrollContainerHeight}" ref="scrollArea">
            <div :id="identifier + '-contentArea'" class="clusterize-content">
                <tr class="clusterize-no-data">
                    <v-progress-circular
                            v-if="showLoading"
                            color="primary"
                            indeterminate>
                    </v-progress-circular>
                </tr>
            </div>
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
            }
        },
        watch: {
            tracks() {
                this.initializeTracksTable();
            }
        },
        methods: {
            initializeTracksTable() {
                console.log(this.renderFunction(this.tracks));
                this.clusterize = new Clusterize({
                    scrollId: this.identifier + '-scrollArea',
                    contentId: this.identifier + '-contentArea',
                    rows: this.renderFunction(this.tracks),
                });
            },
        },
        computed: {
            showLoading() {
                return this.tracks.length === 0;
            }
        }
    }
</script>

<style scoped>

</style>