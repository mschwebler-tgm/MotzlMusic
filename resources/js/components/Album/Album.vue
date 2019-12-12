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
            }
        },
        async created() {
            this.loadContent();
        },
        methods: {
            async loadContent() {
                await this.loadAlbum();
            },
            async loadAlbum() {
                this.loading = true;
                this.album = await cacheRequest.getAlbum(this.id);
                this.loading = false;
            },
        }
    }
</script>

<style scoped>

</style>
