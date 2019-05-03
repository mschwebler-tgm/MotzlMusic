<template>
    <div>
        <div class="d-flex flex-column align-center">
            <div class="flex-wrap justify-space-around w-100" style="display: flex; height: 308px;">
                <v-progress-circular v-if="!currentPagePlaylists.length"
                                     indeterminate
                                     class="mt-5"
                                     color="spotify"></v-progress-circular>
                <import-playlists-item v-for="playlist in currentPagePlaylists"
                                       :key="playlist.key"
                                       :playlist="playlist"
                                       @playlistClicked="calculateSelectedTracksCount"></import-playlists-item>
            </div>
            <v-pagination
                    class="mt-3"
                    :length="initialized ? Math.ceil(totalPlaylists / pageLimit): 1"
                    :disabled="!initialized"
                    v-model="page"
                    color="spotify"
                    :total-visible="10"></v-pagination>
        </div>
    </div>
</template>

<script>
    import Vue from "vue";
    import ImportPlaylistsItem from "./ImportPlaylistsItem";

    export default {
        name: "ImportPlaylists",
        components: {ImportPlaylistsItem},
        data() {
            return {
                page: 1,
                pageLimit: 5,
                playlists: {},
                initialized: false,
                importAll: false,
            }
        },
        created() {
            this.loadPlaylists(1);
        },
        watch: {
            page(page) {
                if (!this.playlists[page]) {
                    this.loadPlaylists(page);
                }
            },
        },
        methods: {
            loadPlaylists(page) {
                axios.get('/api/spotify/playlists/my', {
                    params: {
                        page,
                        limit: this.pageLimit,
                    }
                }).then(res => {
                    if (!this.totalPlaylists) {
                        this.totalPlaylists = res.data.total;
                        this.initialized = true;
                    }
                    Vue.set(this.playlists, page, res.data.items);
                });
            },
            calculateSelectedTracksCount() {
                const playlistPages = Object.values(this.playlists);
                const flatPlaylists = playlistPages.reduce((flat, playlistPage) => flat.concat(playlistPage), []);
                const selectedPlaylists = flatPlaylists.filter(playlist => playlist.selected);
                const trackCount = selectedPlaylists.reduce((count, playlist) => count + playlist.tracks, 0);
                this.$emit('updateSelectCount', trackCount);
            }
        },
        computed: {
            currentPagePlaylists() {
                return this.playlists[this.page] || [];
            }
        }
    }
</script>

<style scoped>

</style>
