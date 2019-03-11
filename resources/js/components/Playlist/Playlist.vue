<template>
    <div>
        <!-- ERROR -->
        <div v-if="errorResponse" class="playlist-error">
            <div>
                <div class="error">
                    <h1 class="display-3 font-weight-light">
                        <v-icon x-large>lock</v-icon>
                        {{ errorResponse.status }} - {{ errorResponse.statusText }}
                    </h1>
                </div>
                <br>
                <h2 class="subheading">{{ errorResponse.data }}</h2>
            </div>
            <img src="/images/403.svg" alt="403" width="400">
        </div>

        <!-- PLAYLIST -->
        <template v-if="playlist">
            <div class="d-flex">
                <v-img
                        :src="playlist.spotify_image_medium"
                        :lazy-src="playlist.spotify_image_small"
                        aspect-ratio="1"
                        class="grey lighten-2 playlist-image">
                    <template v-slot="placeholder">
                        <v-layout
                                fill-height
                                align-center
                                justify-center
                                ma-0>
                            <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                        </v-layout>
                    </template>
                </v-img>
                <div class="playlist-name pa-3">
                    <h1 class="display-1 font-weight-light">{{ playlist.name }}</h1>
                    <h2 class="subheading">{{ playlistType }}</h2>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
    export default {
        name: "Playlist",
        props: {
            name: String,
            id: String,
        },
        data() {
            return {
                errorResponse: null,
            }
        },
        created() {
            if (!this.playlist) {
                axios.get(`/api/playlist/${this.id}`)
                    .then(res => this.$store.commit('cache/setSelectedPlaylist', res.data))
                    .catch(err => {
                        this.errorResponse = (({status, statusText, data}) => ({
                            status,
                            statusText,
                            data
                        }))(err.response);
                    });
            }
        },
        computed: {
            playlist() {
                let cachedPlaylist = this.$store.getters['cache/selectedPlaylist'];
                if (cachedPlaylist && cachedPlaylist.id === parseInt(this.id)) {
                    return cachedPlaylist;
                }

                return null;
            },
            playlistType() {
                if (this.playlist.spotify_id) {
                    return 'Spotify Playlist';
                }

                return 'Playlist';
            }
        }
    }
</script>

<style scoped>
    .playlist-error {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        align-items: center;
    }

    .playlist-error .error h1 {
        display: flex;
        align-items: center;
        justify-content: space-evenly;
        margin: 0 10px;
        padding: 0 10px;
    }

    .playlist-image {
        max-width: 190px;
    }

    .playlist-name {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        border-bottom: 1px solid rgba(0,0,0,.12);
    }
</style>
