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
        Test
    </v-container>
</template>

<script>
    import cacheRequest from "$scripts/cacheReqest/cacheRequest";

    export default {
        name: "Album",
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
            }
        },
        async created() {
            this.loadContent();
        },
        methods: {
            async loadContent() {
                await this.loadAlbum();
                this.loadTracks();
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
        }
    }
</script>

<style scoped>

</style>
