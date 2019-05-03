<template>
    <div>
        <div class="d-flex flex-column align-center">
            <div class="flex-wrap justify-space-between w-100" style="display: flex; height: 308px;">
                <import-playlists-item :playlist="playlist" v-for="playlist in currentPagePlaylists" :key="playlist.key"></import-playlists-item>
            </div>
            <v-pagination
                    class="mt-3"
                    :length="initialized ? Math.ceil(totalPlaylists / pageLimit): 1"
                    :disabled="!initialized"
                    v-model="page"
                    color="spotify"
                    :total-visible="10"></v-pagination>
        </div>

        <v-checkbox v-model="importAll"
                    color="spotify"
                    label="Import all playlists from Spotify"></v-checkbox>
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
