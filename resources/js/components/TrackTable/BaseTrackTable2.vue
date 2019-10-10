<template>
    <div>
        <div :id="scrollId"
             class="clusterize-scroll">
            <div :id="contentId"
                 class="clusterize-content">
            </div>
        </div>
    </div>
</template>

<script>
    import Clusterize from "clusterize.js";
    import DesktopClusterizer from "$scripts/components/TrackTable/Clusterizer/Desktop/DesktopClusterizer";
    import {columns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";

    export default {
        name: "BaseTrackTable2",
        props: {
            tracks: Array,
        },
        data() {
            return {
                tableId: 'table' + Math.random().toString(36).substring(7),
                clusterizer: null,
            }
        },
        created() {
            this.initializeClusterizer();
        },
        mounted() {
            this.initializeTracksTable();
        },
        methods: {
            initializeClusterizer() {
                const clusterizer = new DesktopClusterizer();
                clusterizer.configure({
                    columns: columns.TRACK_TITLE,
                });

                this.clusterizer = clusterizer;
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
                        // clusterChanged: () => this.clusterChanged()
                    }
                });
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

<style scoped>

</style>
