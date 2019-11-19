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
                           fab outlined>
                        <v-icon large>play_arrow</v-icon>
                    </v-btn>
                </div>
                <div class="caption grey--text mt-1" v-if="tracks.length">
                    {{ tracks.length }} track{{ tracks.length > 1 ? 's' : ''}}
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
        <track-table :tracks="tracks"
                     :class="{'pa-3': !$root.isMobile}"
                     height="444px"></track-table>
    </v-container>
</template>

<script>
    import cacheRequest from "$scripts/cacheReqest/cacheRequest";
    import axios from 'axios';
    import TrackTable from "$scripts/components/TrackTable/TrackTable";

    export default {
        name: "Artist",
        components: {TrackTable},
        props: {
            id: [String, Number],
            onlyOwnTracks: Boolean,
        },
        data() {
            return {
                loading: false,
                artist: null,
                tracks: [],
                showAllTracks: !this.onlyOwnTracks,
                ownTrackIds: [],
            }
        },
        watch: {
            async showAllTracks(showAll) {
                if (showAll) {
                    const trackIds = this.artist.tracks.map(track => track.id);
                    this.tracks = await cacheRequest.getTracks(trackIds, this.artist.tracks_url);
                } else {
                    this.tracks = await cacheRequest.getTracks(this.ownTrackIds);
                }
            }
        },
        async created() {
            await this.loadArtist();
            this.loadTracks();
        },
        methods: {
            async loadArtist() {
                this.loading = true;
                this.artist = await cacheRequest.getArtist(this.id);
                this.loading = false;
            },
            async loadTracks() {
                let trackIds = [];
                if (this.onlyOwnTracks) {
                    const response = await axios.get(`/api/my/artist/${this.id}/tracksIds`);
                    trackIds = response.data;
                    this.ownTrackIds = trackIds;
                } else {
                    trackIds = this.artist.tracks.map(track => track.id);
                }
                this.tracks = await cacheRequest.getTracks(trackIds);
            }
        }
    }
</script>
