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
                <track-table :tracks="tracks" height="680px"></track-table>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import TrackTable from "../../TrackTable/TrackTable";
    import renderFunction from '../../../store/modules/myLibrary/helpers/clusterizeTracks';
    import {mapGetters} from "vuex";

    export default {
        name: "Tracks",
        components: {TrackTable},
        data() {
            return {
                renderFunction,
            }
        },
        computed: {
            ...mapGetters('myLibrary', [
                'tracks',
                'tracksInitialized',
            ]),
            noPlaylistsAvailable() {
                return this.tracksInitialized && this.tracks.length === 0;
            },
        }
    }
</script>

<style lang="scss">

</style>
