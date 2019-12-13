<template>
    <v-container>
        <base-playable-item-view :id="id"
                                 :only-own-tracks="onlyOwnTracks"
                                 :table-config="tableConfig"
                                 type="album"
                                 related-items-key="artists">
        </base-playable-item-view>
    </v-container>
</template>

<script>
    import {columns as mobileColumns} from "$scripts/components/TrackTable/Clusterizer/Mobile/columns";
    import {columns as desktopColumns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";
    import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";
    import BasePlayableItemView from "$scripts/components/_BaseComponents/BasePlayableItemView";
    import {slugify} from "$scripts/helpers";

    export default {
        name: "Album",
        components: {BasePlayableItemView},
        props: {
            id: [String, Number],
            onlyOwnTracks: Boolean,
        },
        computed: {
            tableConfig() {
                const options = new ClusterizeOptions();
                options.setOptions({
                    mobileColumns: [
                        mobileColumns.TITLE_AND_ARTIST,
                        mobileColumns.DURATION,
                        mobileColumns.TRACK_OPTIONS,
                    ],
                    desktopColumns: [
                        desktopColumns.INDEX,
                        desktopColumns.TRACK_TITLE,
                        desktopColumns.DURATION,
                        desktopColumns.ARTISTS,
                        desktopColumns.RATING,
                        desktopColumns.INFO_ICONS,
                        desktopColumns.TRACK_OPTIONS,
                    ],
                    showQueueIndicators: true,
                    activatable: true,
                    contextMenu: true,
                    playable: true,
                    queueable: true,
                    desktop: !this.$root.isMobile,
                    draggable: false,
                });

                return options;
            }
        },
        methods: {
            slugify(text) {
                return slugify(text);
            }
        }
    }
</script>

<style scoped>
    .to-artist:not(:last-child)::after {
        content: ',';
        text-decoration: none !important;
    }
</style>
