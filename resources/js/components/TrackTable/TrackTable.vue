<template>
    <base-track-table2
            :tracks="tracks"
            :options="tableConfig"
            @select-track="selectTrack"
            @play-track="playTrack"
            @rate-track="rateTrack"
            @queue-track="queueTrack"
            @focusout="resetSelectedTracks"
            :height="height">
    </base-track-table2>
</template>

<script>
    import BaseTrackTable2 from "./BaseTrackTable2";
    import {columns as mobileColumns} from "$scripts/components/TrackTable/Clusterizer/Mobile/columns";
    import {columns as desktopColumns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";
    import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";
    import player from "$store/player/helpers/v2/player";

    export default {
        name: "TrackTable",
        components: {BaseTrackTable2},
        props: {
            tracks: Array,
            height: String,
        },
        methods: {
            resetSelectedTracks() {
                this.$store.commit('subContent/setFocusedItems', []);
            },
            selectTrack(track) {
                this.$store.commit('subContent/setFocusedItems', [track]);
            },
            playTrack(track) {
                player.playList(this.tracks, this.tracks.findIndex(listTrack => listTrack.id === track.id))
            },
            rateTrack(track, rating) {
                this.$store.dispatch('tracks/rateTrack', {track, rating});
            },
            queueTrack(track) {
                player.queueTrack(track);
            },
        },
        computed: {
            tableConfig() {
                const options = new ClusterizeOptions();
                options.setOptions({
                    mobileColumns: [
                        mobileColumns.ALBUM_IMAGE,
                        mobileColumns.TITLE_AND_ARTIST,
                        mobileColumns.DURATION,
                        mobileColumns.TRACK_OPTIONS,
                    ],
                    desktopColumns: [
                        desktopColumns.INDEX,
                        desktopColumns.ALBUM_IMAGE,
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
                });

                return options;
            }
        }
    }
</script>
