<template>
    <v-container>
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
                artist: null,
                tracks: [],
            }
        },
        async created() {
            await this.loadArtist();
            this.loadTracks();
        },
        methods: {
            async loadArtist() {
                this.artist = await cacheRequest.getArtist(this.id);
            },
            async loadTracks() {
                let trackIds = [];
                if (this.onlyOwnTracks) {
                    const response = await axios.get(`/api/my/artist/${this.id}/tracksIds`);
                    trackIds = response.data;
                } else {
                    trackIds = this.artist.tracks.map(track => track.id);
                }
                this.tracks = await cacheRequest.getTracks(trackIds);
            }
        }
    }
</script>
