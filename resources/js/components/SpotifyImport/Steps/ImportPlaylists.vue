<template>
    <div>
        <div class="d-flex flex-column align-center">
            <div class="flex-wrap justify-space-around w-100"
                 style="display: flex; min-height: 308px;"
                 id="spotify-import-playlist-container"
                 ref="spotify-import-playlist-container">
                <v-progress-circular v-if="!currentPagePlaylists.length"
                                     indeterminate
                                     class="mt-5"
                                     color="spotify"></v-progress-circular>
                <import-playlists-item v-if="readyToLoadPlaylists"
                                       v-for="playlist in currentPagePlaylists"
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
                readyToLoadPlaylists: false,
            }
        },
        mounted() {
            function waitForElement(element, callback) {
                if (!element.offsetWidth) {
                    setTimeout(() => waitForElement(element, callback), 100);
                } else {
                    callback(element.offsetWidth);
                }
            }

            const $element = this.$refs['spotify-import-playlist-container'];
            waitForElement($element, width => {
                this.pageLimit = Math.floor(width / 200);
                this.pageLimit = Math.max(this.pageLimit, 4);
                this.readyToLoadPlaylists = true;
                this.loadPlaylists(1);
            });
        },
        watch: {
            page(page) {
                if (!this.playlists[page] && this.readyToLoadPlaylists) {
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
    @media screen and (min-width: 0) and (max-width: 599px) {
        #spotify-import-playlist-container {
            flex-wrap: wrap;
        }
    }
</style>
