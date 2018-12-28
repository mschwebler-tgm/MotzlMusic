<template>
    <div class="h-100 clusterize flex-column">
        <h2 class="has-text-weight-light title is-9">Tracks</h2>
        <div class="flex-1 track-table">
            <div :id="identifier + '-scrollArea'" class="clusterize-scroll" :style="{'max-height': scrollContainerHeight}" ref="scrollArea">
                <div :id="identifier + '-contentArea'" class="clusterize-content">
                    <tr class="clusterize-no-data">
                        <b-loading :active="true" :is-full-page="false"></b-loading>
                    </tr>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BSwitch from "buefy/src/components/switch/Switch";
    import BIcon from "buefy/src/components/icon/Icon";
    import Clusterize from "clusterize.js";
    import BLoading from "buefy/src/components/loading/Loading";

    export default {
        components: {
            BLoading,
            BIcon,
            BSwitch
        },
        name: "tracks",
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
            if (!this.$store.getters['myLibrary/tracksInitialized']) {
                const unwatch = this.$store.watch((state, getters) => getters['myLibrary/tracksInitialized'], _ => {
                    this.initializeTracksTable();
                    unwatch();
                });
            } else {
                this.initializeTracksTable();
            }
        },
        methods: {
            initializeTracksTable() {
                setTimeout(() => {
                    this.clusterize = new Clusterize({
                        scrollId: this.identifier + '-scrollArea',
                        contentId: this.identifier + '-contentArea',
                        rows: this.tracksDomElements
                    });
                }, 3000);
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
    @import "../../../sass/components/trackTable";

    .clusterize-no-data {
        position: relative;
    }
</style>