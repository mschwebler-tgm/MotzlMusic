<template>
    <div>
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
            if (!this.cachedPlaylist) {
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
            cachedPlaylist() {
                let cachedPlaylist = this.$store.getters['cache/selectedPlaylist'];
                if (cachedPlaylist && cachedPlaylist.id === parseInt(this.id)) {
                    return cachedPlaylist;
                }

                return null;
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
</style>
