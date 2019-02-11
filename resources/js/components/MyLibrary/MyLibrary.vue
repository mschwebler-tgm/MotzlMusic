<template>
    <router-view></router-view>
</template>

<script>
    import {mapGetters} from 'vuex';

    export default {
        name: "MyLibrary",
        computed: {
            ...mapGetters('myLibrary', [
                'playlists',
                'playlistsInitialized',
                'tracks',
                'tracksInitialized',
                'tracksClusterized',
                'topArtists',
                'topArtistsInitialized',
                'recentArtists',
                'recentArtistsInitialized',
                'albums',
                'albumsInitialized',
            ]),
        }
    }
</script>

<style scoped>

</style>
