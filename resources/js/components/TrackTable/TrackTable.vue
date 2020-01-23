<template>
    <base-track-table
            :tracks="tableTracks"
            :options="config || tableConfig"
            :height="height"
            :hide-headers="hideHeaders"
            @select-track="selectTrack"
            @play-track="playTrack"
            @rate-track="rateTrack"
            @queue-track="queueTrack"
            @remove-track="removeTrack"
            @focusout="resetSelectedTracks"
            @sort="sortTracks"
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
            useRawTracks: Boolean,
            hideHeaders: Boolean,
        },
        data() {
            return {
                tableTracks: [...this.tracks],
            }
        },
        watch: {
            tracks(tracks) {
                this.tableTracks = [...tracks];
            }
        },
        methods: {
            resetSelectedTracks() {
                this.$store.commit('subContent/setAudioFeatures', null);
            },
            selectTrack(track) {
                this.$store.commit('subContent/setAudioFeatures', track.audio_features_url);
            },
            playTrack(track) {
                console.log(track);
                if (this.useRawTracks) {
                    const tracks = this.tableTracks.map(track => track.trackData);
                    player.playIndex(tracks.findIndex(listTrack => listTrack.id === track.id))
                } else {
                    console.log(this.tableTracks.findIndex(listTrack => listTrack.id === track.id));
                    console.log(this.tableTracks);
                    player.playList(this.tableTracks, this.tableTracks.findIndex(listTrack => listTrack.id === track.id))
                }
            },
            rateTrack(track, rating) {
                this.$store.dispatch('tracks/rateTrack', {track, rating});
            },
            queueTrack(track) {
                player.queueTrack(track);
            },
            removeTrack(trackToRemove) {
                const index = this.tableTracks.findIndex(track => track.id === trackToRemove.id);
                this.$store.dispatch('myLibrary/removeTrack', {trackId: trackToRemove.id, onRestore: () => this.restoreTrack(trackToRemove, index)})
                    .then(() => this.tableTracks.splice(index, 1));
            },
            restoreTrack(track, index) {
                this.tableTracks.splice(index, 0, track);
            },
            async sortTracks(sorting) {
                let tracks = this.tableTracks;
                if (this.useRawTracks) {
                    tracks = tracks.map(track => track.trackData);
                }
                const tracksSorted = axios.post('/api/sortTracks', {ids: tracks.map(track => track.id), sorting});
                console.log(tracksSorted);
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
