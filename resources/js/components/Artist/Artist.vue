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
            <v-img :src="$root.getSpotifyImage(artist, 'medium')"
                   aspect-ratio="1"
                   max-width="190px"
                   min-width="190px"
                   class="image-rounded"></v-img>
            <div class="d-flex flex-column pa-3 ml-3">
                <div class="d-flex">
                    <h1 class="display-3 font-weight-thin">{{ artist.name }}</h1>
                    <v-btn color="secondary"
                           aria-label="Start Artist Playback"
                           class="ml-4"
                           @click="playArtist"
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
        <template v-if="albums.length > 0 || !albumsLoaded">
            <div class="pl-3 pt-3 grey--text body-1">Albums
                <span class="caption grey--text" v-if="albumsLoaded">
                    ({{ albums.length }})
                </span>
            </div>
            <base-card-slider :items="albums" :loading="!albumsLoaded"></base-card-slider>
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
    import axios from 'axios';
    import TrackTable from "$scripts/components/TrackTable/TrackTable";
    import player from "$store/player/helpers/v2/player";
    import BaseCardSlider from "$scripts/components/_BaseComponents/BaseCardSlider";

    export default {
        name: "Artist",
        components: {BaseCardSlider, TrackTable},
        props: {
            id: [String, Number],
            onlyOwnTracks: Boolean,
        },
        data() {
            return {
                loading: false,
                artist: null,
                tracks: [],
                ownTrackIds: [],
                ownTrackIdsInitialized: false,
                albums: [],
                albumsLoaded: false,
                ownAlbumIds: [],
                ownAlbumIdsInitialized: false,
                showAllTracks: !this.onlyOwnTracks,
            }
        },
        watch: {
            async showAllTracks(showAll) {
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
                this.tracks = [];
                await this.loadArtist();
                this.loadTracks();
                this.loadAlbums();
            },
            async loadArtist() {
                this.loading = true;
                this.artist = await cacheRequest.getArtist(this.id);
                this.loading = false;
            },
            async loadTracks() {
                let trackIds = [];
                if (this.showAllTracks) {
                    trackIds = this.artist.tracks.map(track => track.id);
                } else if (this.ownTrackIdsInitialized) {
                    trackIds = this.ownTrackIds;
                } else {
                    const response = await axios.get(`/api/my/artist/${this.id}/tracksIds`);
                    trackIds = response.data;
                    this.ownTrackIds = trackIds;
                    this.ownTrackIdsInitialized = true;
                }
                this.tracks = await cacheRequest.getTracks(trackIds);
            },
            async loadAlbums() {
                let albumIds = [];
                if (this.showAllTracks) {
                    albumIds = this.artist.albums.map(track => track.id);
                } else if (this.ownAlbumIdsInitialized) {
                    albumIds = this.ownAlbumIds;
                } else {
                    const response = await axios.get(`/api/my/artist/${this.id}/albumIds`);
                    albumIds = response.data;
                    this.ownAlbumIds = albumIds;
                    this.ownAlbumIdsInitialized = true;
                }
                this.albums = await cacheRequest.getAlbums(albumIds);
                this.albumsLoaded = true;
            },
            playArtist() {
                player.playList(this.tracks);
            }
        }
    }
</script>
