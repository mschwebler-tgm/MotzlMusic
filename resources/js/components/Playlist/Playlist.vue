<template>
    <div>
        <!-- ERROR -->
        <div v-if="errorResponse" class="playlist-error">
            <div>
                <div class="error">
                    <h1 class="display-3 font-weight-light">
                        <v-icon x-large>lock</v-icon>
                        {{ errorResponse.status }} - {{ errorResponse.statusText }}
                    </h1>
                </div>
                <br>
                <h2 class="subheading">{{ errorResponse.data }}</h2>
            </div>
            <img src="/images/403.svg" alt="403" width="400">
        </div>

        <!-- PLAYLIST -->
        <template v-if="playlist">
            <!-- HEADER DESKTOP -->
            <div class="hidden-sm-and-down">
                <div class="d-flex pa-3">
                    <v-img
                            :src="$root.getSpotifyImage(playlist, 'medium')"
                            :lazy-src="$root.getSpotifyImage(playlist, 'small')"
                            aspect-ratio="1"
                            class="grey lighten-2 playlist-image">
                        <template v-slot="placeholder">
                            <v-layout
                                    fill-height
                                    align-center
                                    justify-center
                                    ma-0>
                                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                            </v-layout>
                        </template>
                    </v-img>
                    <div class="playlist-name pa-3 relative flex-grow-1">
                        <h1 class="display-1 font-weight-light">{{ playlist.name }}</h1>
                        <h2 class="subheading">{{ playlistType }}</h2>
                        <playlist-actions :playlist-id="id"></playlist-actions>
                    </div>
                </div>
            </div>
            <!-- HEADER MOBILE -->
            <div class="hidden-md-and-up">
                <div class="relative">
                    <v-img
                            :src="$root.getSpotifyImage(playlist, 'medium')"
                            :lazy-src="$root.getSpotifyImage(playlist, 'small')"
                            aspect-ratio="1"
                            min-width="100%"
                            class="grey lighten-2 playlist-image">
                        <template v-slot="placeholder">
                            <v-layout
                                    fill-height
                                    align-center
                                    justify-center
                                    ma-0>
                                <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                            </v-layout>
                        </template>
                    </v-img>
                    <v-btn icon fab absolute bottom right medium
                           v-if="!isPlaying"
                           @click="playPlaylist"
                           aria-label="Start playlist"
                           color="secondary">
                        <v-icon large>play_arrow</v-icon>
                    </v-btn>
                    <v-btn icon disabled large class="overlay-playing-icon" aria-label="Playing" v-else>
                        <v-icon large color="white">equalizer</v-icon> <!-- TODO animated SVG? -->
                    </v-btn>
                </div>
                <div class="pa-3">
                    <div class="title">{{ playlist.name }}</div>
                    <div class="pt-2 playlist-header-mobile">
                        <img src="/images/spotify_black.png" height="30" width="30" alt="spotify">
                        <div class="flex-column pl-2 flex-1">
                            <div class="body-2 font-weight-regular">Spotify Playlist</div>
                            <div class="caption font-weight-thin">5 Tracks</div>
                        </div>
                        <playlist-actions :playlist-id="id"></playlist-actions>
                    </div>
                </div>
            </div>
            <track-table :tracks="tracks"
                         :render-function="clusterizeFunction"
                         :class="{'pa-3': !$root.isMobile}"
                         height="470px"></track-table>
        </template>
    </div>
</template>

<script>
    import TrackTable from "../TrackTable/TrackTable";
    import clusterizeTracks, {clusterizeTracksMobile} from '../../store/modules/myLibrary/helpers/clusterizeTracks';
    import PlaylistActions from "./PlaylistActions";

    export default {
        name: "Playlist",
        components: {PlaylistActions, TrackTable},
        props: {
            name: String,
            id: String,
        },
        data() {
            return {
                errorResponse: null,
                tracks: [],
                clusterizeFunction: this.$root.isMobile ? clusterizeTracksMobile : clusterizeTracks,
            }
        },
        created() {
            this.loadPlaylistIfNeeded();
            this.loadTracks();
            this.initArrowListeners();
        },
        methods: {
            loadPlaylistIfNeeded() {
                if (!this.playlist) {
                    axios.get(`/api/playlist/${this.id}`)
                        .then(res => this.$store.commit('cache/setSelectedPlaylist', res.data))
                        .catch(err => this.handleError(err));
                }
            },
            loadTracks() {
                axios.get(`/api/playlist/${this.id}/tracks`)
                    .then(res => this.tracks = res.data)
                    .catch(err => this.handleError(err));
            },
            handleError(error) {
                this.errorResponse = (({status, statusText, data}) => ({
                    status,
                    statusText,
                    data: data.message,
                }))(error.response);
            },
            playPlaylist() {
                this.$store.dispatch('player/playList', {type: 'playlist', list: this.playlist});
            },
            initArrowListeners() {
                const handleKeyDown = $event => {
                    let somethingIsFocused = this.$store.getters['subContent/focusedItems'].length > 0;
                    let shouldRemoveEventListener = somethingIsFocused || $event.key === 'ArrowUp' || $event.key === 'ArrowDown';
                    if (shouldRemoveEventListener) {
                        $event.preventDefault();
                        $event.stopPropagation();
                        document.removeEventListener("keydown", handleKeyDown);
                        if (!somethingIsFocused && $event.key === 'ArrowDown') {
                            this.selectFirstTrack();
                        }
                        if (!somethingIsFocused && $event.key === 'ArrowUp') {
                            this.selectLastTrack();
                        }
                    }
                };
                document.addEventListener('keydown', handleKeyDown);
            },
            getTrackElements() {
                const trackHolderElement = this.$el.querySelector('.track-table .clusterize-content');
                return trackHolderElement.childNodes;
            },
            selectFirstTrack() {
                const trackElements = this.getTrackElements();
                if (trackElements.length) {
                    trackElements[0].focus();
                }
            },
            selectLastTrack() {
                const trackElements = this.getTrackElements();
                if (trackElements.length) {
                    trackElements[trackElements.length - 1].focus();
                }
            }
        },
        computed: {
            playlist() {
                let cachedPlaylist = this.$store.getters['cache/selectedPlaylist'];
                if (cachedPlaylist && cachedPlaylist.id === parseInt(this.id)) {
                    return cachedPlaylist;
                }

                return null;
            },
            playlistType() {
                if (this.playlist.spotify_id) {
                    return 'Spotify Playlist';
                }

                return 'Playlist';
            },
            isPlaying() {
                const activeItem = this.$store.getters['player/activeItem'];
                return activeItem.type === 'playlist' && activeItem.id === this.playlist.id;
            }
        }
    }
</script>

<style scoped>
    .playlist-error {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
    }

    .playlist-error .error h1 {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        margin: 0 10px;
        padding: 0 10px;
    }

    .playlist-image {
        max-width: 190px;
        min-width: 190px;
    }

    .playlist-name {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        border-bottom: 1px solid rgba(0, 0, 0, .12);
    }

    .overlay-playing-icon {
        position: absolute !important;
        bottom: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.42);
    }

    .playlist-header-mobile {
        display: flex;
        align-items: center;
    }

</style>
