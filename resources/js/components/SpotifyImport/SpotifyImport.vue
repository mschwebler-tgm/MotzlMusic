<template>
    <v-card>
        <v-card-title class="headline">Import from spotify!</v-card-title>
        <img src="/images/spotify_black.png" alt="spotify-logo" class="spotify-logo">
        <v-container>
            <transition name="spotify-import-stepper" mode="out-in">
                <v-stepper v-model="step" non-linear v-if="!importSubmitted">
                    <v-stepper-header>
                        <v-stepper-step color="spotify" :complete="step > 1" step="1">Playlists</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step color="spotify" :complete="step > 2" step="2">Tracks</v-stepper-step>
                        <v-divider></v-divider>
                        <v-stepper-step color="spotify" step="3">Albums</v-stepper-step>
                    </v-stepper-header>

                    <v-stepper-items>
                        <v-stepper-content step="1">
                            <import-playlists @selectPlaylists="selectPlaylists"></import-playlists>
                            <v-btn outline color="spotify" @click="step++">Continue</v-btn>
                            <v-btn flat @click="step=3">Back</v-btn>
                            <p class="headline spotify--text right ma-2">{{ accumulatedSelectedTracksCount }}</p>
                        </v-stepper-content>

                        <v-stepper-content step="2">
                            <import-tracks @updateSelectCount="updateSelectedSavedTracksCount"></import-tracks>
                            <v-btn outline color="spotify" @click="step++">Continue</v-btn>
                            <v-btn flat @click="step--">Back</v-btn>
                            <p class="headline spotify--text right ma-2">{{ accumulatedSelectedTracksCount }}</p>
                        </v-stepper-content>

                        <v-stepper-content step="3">
                            <import-albums></import-albums>
                            <v-btn outline color="spotify" @click="submit">Import</v-btn>
                            <v-btn flat @click="step--">Back</v-btn>
                            <p class="headline spotify--text right ma-2">{{ accumulatedSelectedTracksCount }}</p>
                        </v-stepper-content>
                    </v-stepper-items>
                </v-stepper>
                <div class="justify-center align-center flex-column pa-5" style="display: flex;"
                     v-else="importSubmitted">
                    <div class="display-1 spotify--text">Import in progress...</div>
                    <div class="subheading mt-1">This could take some time</div>
                </div>
            </transition>
        </v-container>
    </v-card>
</template>

<script>
    import ImportTracks from "./Steps/ImportTracks";
    import ImportPlaylists from "./Steps/ImportPlaylists";
    import ImportAlbums from "./Steps/ImportAlbums";

    export default {
        name: "SpotifyImport",
        components: {ImportAlbums, ImportPlaylists, ImportTracks},
        data() {
            return {
                playlists: {items: []},
                albums: {items: []},
                loading: true,
                step: 1,
                selectedSavedTracksCount: 0,
                selectedPlaylistTracksCount: 0,
                selectedPlaylistIds: [],
                importSubmitted: false,
            }
        },
        created() {
            this.loadData();
        },
        methods: {
            loadData() {
                const albums = axios.get('/api/spotify/albums/my').then(res => this.albums = res.data);
                Promise.all([albums]).then(() => this.loading = false);
            },
            updateSelectedSavedTracksCount(count) {
                this.selectedSavedTracksCount = count;
            },
            selectPlaylists(selectedPlaylists) {
                this.selectedPlaylistIds = selectedPlaylists.map(playlist => playlist.id);
                this.selectedPlaylistTracksCount = selectedPlaylists.reduce((count, playlist) => count + playlist.tracks, 0);
            },
            submit() {
                this.importSubmitted = true;
                axios.post('/api/spotify/import', {
                    importSavedTracks: this.selectedSavedTracksCount > 0,
                    playlistIds: this.selectedPlaylistIds,
                });
            }
        },
        computed: {
            accumulatedSelectedTracksCount() {
                return this.selectedSavedTracksCount +
                    this.selectedPlaylistTracksCount;
            }
        }
    }
</script>

<style scoped>
    .spotify-import-stepper-leave-active {
        animation: spotify-import-stepper .2s ease-out;
    }

    .spotify-import-stepper-enter-active {
        animation: spotify-import-stepper 1.5s ease-in reverse;
    }

    @keyframes spotify-import-stepper {
        0% {
            opacity: 1;
        }
        50% {
            opacity: .2;
        }
        100% {
            -webkit-transform: translate3d(0, 1rem, 0);
            -moz-transform: translate3d(0, 1rem, 0);
            -ms-transform: translate3d(0, 1rem, 0);
            -o-transform: translate3d(0, 1rem, 0);
            transform: translate3d(0, 1rem, 0);
            opacity: 0;
        }
    }

    .my-library-enter-active {
        animation: my-library .2s ease-out;
    }

    .my-library-leave-active {
        animation: my-library .1s reverse ease-in;
    }

    @keyframes my-library {
        0% {
            -webkit-transform: translate3d(1rem, 0, 0);
            -moz-transform: translate3d(1rem, 0, 0);
            -ms-transform: translate3d(1rem, 0, 0);
            -o-transform: translate3d(1rem, 0, 0);
            transform: translate3d(1rem, 0, 0);
            opacity: 0;
        }
        50% {
            opacity: .8;
        }
        100% {
            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
            -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
    }

    .spotify-logo {
        position: absolute;
        top: 0;
        right: 0;
        width: 50px;
        height: 50px;
        margin: 16px;
    }
</style>
