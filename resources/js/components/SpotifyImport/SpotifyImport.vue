<template>
    <v-card>
        <v-card-title class="headline">Import from spotify!</v-card-title>
        <img src="/images/spotify_black.png" alt="spotify-logo" class="spotify-logo">
        <v-container>

        </v-container>
    </v-card>
</template>

<script>
    export default {
        name: "SpotifyImport",
        data() {
          return {
              playlists: null,
              tracks: null,
              albums: null,
              loading: true,
          }
        },
        created() {
            this.loadData();
        },
        methods: {
            loadData() {
                const playlists = axios.get('/api/spotify/playlists/my').then(res => this.playlists = res.data);
                const tracks = axios.get('/api/spotify/tracks/my').then(res => this.tracks = res.data);
                const albums = axios.get('/api/spotify/albums/my').then(res => this.albums = res.data);
                Promise.all([playlists, tracks, albums]).then(() => this.loading = false);
            }
        }
    }
</script>

<style scoped>
    .my-library-enter-active {
        animation: my-library .2s ease-out;
    }

    .my-library-leave-active {
        animation: my-library .1s reverse ease-in;
    }

    @keyframes my-library {
        0% {
            -webkit-transform: translate3d(1rem, 0, 0);
            -moz-transform: translate3d(1rem, 0, 0);
            -ms-transform: translate3d(1rem, 0, 0);
            -o-transform: translate3d(1rem, 0, 0);
            transform: translate3d(1rem, 0, 0);
            opacity: 0;
        }
        50% {
            opacity: .8;
        }
        100% {
            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
            -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
    }

    .spotify-logo {
        position: absolute;
        top: 0;
        right: 0;
        width: 50px;
        height: 50px;
        margin: 16px;
    }
</style>
