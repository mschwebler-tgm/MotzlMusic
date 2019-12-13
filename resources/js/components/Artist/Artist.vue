<template>
    <v-container>
        <base-playable-item-view
            :id="id"
            :only-own-tracks="onlyOwnTracks"
            :table-config="tableConfig"
            rounded-image
            type="artist"
            related-items-key="albums"
        ></base-playable-item-view>
    </v-container>
</template>

<script>
    import {columns as mobileColumns} from "$scripts/components/TrackTable/Clusterizer/Mobile/columns";
    import {columns as desktopColumns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";
    import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";
    import BasePlayableItemView from "$scripts/components/_BaseComponents/BasePlayableItemView";

    export default {
        name: "Artist",
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
                        mobileColumns.ALBUM_TITLE,
                    ],
                    desktopColumns: [
                        desktopColumns.INDEX,
                        desktopColumns.TRACK_TITLE,
                        desktopColumns.DURATION,
                        desktopColumns.ALBUM_TITLE,
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
    }
</script>
