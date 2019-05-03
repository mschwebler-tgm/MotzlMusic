<template>
    <div class="d-flex flex-column align-center">
        <div>
<!--            <span v-for="playlist in currentPagePlaylists">{{ playlist.name }}</span>-->
        </div>
        <v-pagination
                :length="initialized ? Math.ceil(totalPlaylists / pageLimit): 1"
                :disabled="!initialized"
                v-model="page"
                color="spotify"
                :total-visible="10"></v-pagination>
    </div>
</template>

<script>
    import Vue from "vue";

    export default {
        name: "ImportPlaylists",
        data() {
            return {
                page: 1,
                pageLimit: 5,
                playlists: {},
                initialized: false,
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
