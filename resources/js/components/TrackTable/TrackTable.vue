<template>
    <base-track-table
            :tracks="tracks"
            :options="config || tableConfig"
            :height="height"
            @select-track="selectTrack"
            @play-track="playTrack"
            @rate-track="rateTrack"
            @queue-track="queueTrack"
            @remove-track="removeTrack"
            @focusout="resetSelectedTracks"
            v-on="$listeners">
    </base-track-table>
</template>

<script>
    import BaseTrackTable from "./BaseTrackTable";
    import {columns as mobileColumns} from "$scripts/components/TrackTable/Clusterizer/Mobile/columns";
    import {columns as desktopColumns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";
    import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";
    import player from "$store/player/helpers/v2/player";

    export default {
        name: "TrackTable",
        components: {BaseTrackTable},
        props: {
            tracks: Array,
            height: String,
            config: Object,
            useRawTracks: Boolean
        },
        methods: {
            resetSelectedTracks() {
                this.$store.commit('subContent/setAudioFeatures', null);
            },
            selectTrack(track) {
                this.$store.commit('subContent/setAudioFeatures', track.audio_features_url);
            },
            playTrack(track) {
                if (this.useRawTracks) {
                    const tracks = this.tracks.map(track => track.trackData);
                    player.playIndex(tracks.findIndex(listTrack => listTrack.id === track.id))
                } else {
                    player.playList(this.tracks, this.tracks.findIndex(listTrack => listTrack.id === track.id))
                }
            },
            rateTrack(track, rating) {
                this.$store.dispatch('tracks/rateTrack', {track, rating});
            },
            queueTrack(track) {
                player.queueTrack(track);
            },
            removeTrack(trackToRemove) {
                const index = this.tracks.findIndex(track => track.id === trackToRemove.id);
                this.$store.dispatch('myLibrary/removeTrack', {trackId: trackToRemove.id, onRestore: () => this.restoreTrack(trackToRemove, index)})
                    .then(() => this.tracks.splice(index, 1));
            },
            restoreTrack(track, index) {
                this.tracks.splice(index, 0, track);
            }
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
                    draggable: false,
                });

                return options;
            }
        }
    }
</script>
