<template>
    <v-container>
        <div class="d-flex" v-if="loading">
            <v-skeleton-loader type="image" width="190"></v-skeleton-loader>
            <v-skeleton-loader type="sentences" width="400" class="ml-3 d-flex"></v-skeleton-loader>
            <div class="flex-1 d-flex justify-end align-end">
                <v-skeleton-loader type="button" width="80"></v-skeleton-loader>
                <v-skeleton-loader type="button"></v-skeleton-loader>
            </div>
        </div>
        <div class="d-flex pa-3" v-else>
            <v-img :src="$root.getSpotifyImage(album, 'medium')"
                   aspect-ratio="1"
                   max-width="190px"
                   min-width="190px"></v-img>
            <div class="d-flex flex-column pa-3 ml-3">
                <div class="d-flex">
                    <h1 class="display-3 font-weight-thin">{{ album.name }}</h1>
                    <v-btn color="secondary"
                           aria-label="Start Artist Playback"
                           class="ml-4"
                           @click="playAlbum"
                           fab outlined>
                        <v-icon large>play_arrow</v-icon>
                    </v-btn>
                </div>
                <div class="mt-auto">
                    <v-switch
                        v-model="showAllTracks"
                        label="Show all tracks (from global library)"
                        hide-details
                    ></v-switch>
                </div>
            </div>
        </div>
        <v-divider></v-divider>
        <template v-if="artists.length > 0 || !artistsLoaded">
            <div class="pl-3 pt-3 grey--text body-1">Artists
                <span class="caption grey--text" v-if="artistsLoaded">
                    ({{ artists.length }})
                </span>
            </div>
            <base-card-slider :items="artists" :loading="!artistsLoaded" rounded></base-card-slider>
        </template>
        <div class="pl-3 pt-3 grey--text body-1">
            Tracks
            <span class="caption grey--text">
                ({{ tracks.length }})
            </span>
        </div>
        <track-table :tracks="tracks"
                     :class="{'pa-3': !$root.isMobile}"
                     height="444px"></track-table>
    </v-container>
</template>

<script>
    import cacheRequest from "$scripts/cacheReqest/cacheRequest";
    import player from "$store/player/helpers/v2/player";
    import BaseCardSlider from "$scripts/components/_BaseComponents/BaseCardSlider";
    import TrackTable from "$scripts/components/TrackTable/TrackTable";

    export default {
        name: "Album",
        components: {TrackTable, BaseCardSlider},
        props: {
            id: [String, Number],
            onlyOwnTracks: Boolean,
        },
        data() {
            return {
                loading: false,
                album: null,
                showAllTracks: !this.onlyOwnTracks,
                tracks: [],
                ownTrackIds: [],
                ownTrackIdsInitialized: false,
                artists: [],
                ownArtistIds: [],
                ownArtistIdsInitialized: false,
                artistsLoaded: false,
            }
        },
        watch: {
            async showAllTracks() {
                this.loadTracks();
                this.loadAlbums();
            },
            id() {
                this.loadContent();
            }
        },
        async created() {
            this.loadContent();
        },
        methods: {
            async loadContent() {
                await this.loadAlbum();
                this.loadTracks();
                this.loadArtists();
            },
            async loadAlbum() {
                this.loading = true;
                this.album = await cacheRequest.getAlbum(this.id);
                this.loading = false;
            },
            async loadTracks() {
                let trackIds = [];
                if (this.showAllTracks) {
                    trackIds = this.album.tracks.map(track => track.id);
                } else if (this.ownTrackIdsInitialized) {
                    trackIds = this.ownTrackIds;
                } else {
                    const response = await axios.get(`/api/my/album/${this.id}/tracksIds`);
                    trackIds = response.data;
                    this.ownTrackIds = trackIds;
                    this.ownTrackIdsInitialized = true;
                }
                this.tracks = await cacheRequest.getTracks(trackIds);
            },
            async loadArtists() {
                let artistIds = [];
                if (this.showAllTracks) {
                    artistIds = this.album.artists.map(artist => artist.id);
                } else if (this.ownArtistIdsInitialized) {
                    artistIds = this.ownArtistIds;
                } else {
                    const response = await axios.get(`/api/my/album/${this.id}/artistIds`);
                    artistIds = response.data;
                    this.ownArtistIds = artistIds;
                    this.ownArtistIdsInitialized = true;
                }
                this.artists = await cacheRequest.getArtists(artistIds);
                this.artistsLoaded = true;
            },
            playAlbum() {
                player.playList(this.tracks);
            }
        }
    }
</script>

<style scoped>

</style>
