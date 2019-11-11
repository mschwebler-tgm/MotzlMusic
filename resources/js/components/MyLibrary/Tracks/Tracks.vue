<template>
    <div>
        <v-container>
            <div v-if="noPlaylistsAvailable">
                <div class="d-flex align-center flex-column">
                    <p class="subheading">You have no playlists in your library</p>
                    <div>
                        <v-btn color="primary" to="/upload">upload some!</v-btn>
                        <v-btn text color="primary" to="/import/spotify">Import from spotify</v-btn>
                    </div>
                </div>
            </div>
            <v-layout column v-else>
                <track-table :tracks="tracks" :config="tableConfig" height="680px"></track-table>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import TrackTable from "../../TrackTable/TrackTable";
    import {mapGetters} from "vuex";
    import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";
    import {columns as mobileColumns} from "$scripts/components/TrackTable/Clusterizer/Mobile/columns";
    import {columns as desktopColumns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";

    export default {
        name: "Tracks",
        components: {TrackTable},
        computed: {
            ...mapGetters('myLibrary', [
                'tracks',
                'tracksInitialized',
            ]),
            noPlaylistsAvailable() {
                return this.tracksInitialized && this.tracks.length === 0;
            },
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
                    draggableOptions: {}
                });

                return options;
            }
        }
    }
</script>

<style lang="scss">

</style>
