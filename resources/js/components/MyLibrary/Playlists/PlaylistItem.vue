<template>
    <v-card tile
            hover
            @click="openPlaylistDetails">
        <v-img
                :src="fullResolutionImage"
                :lazy-src="intermediateImage"
                :alt="playlist.name"
                aspect-ratio="1"></v-img>
        <v-card-title primary-title>
            <div class="no-overflow">
                <h4 class="subheading mb-0 playlist-title">{{ playlist.name }}</h4>
            </div>
        </v-card-title>
    </v-card>
</template>

<script>
    export default {
        name: "PlaylistItem",
        props: {
            playlist: Object,
        },
        data() {
            return {
                width: 170
            }
        },
        methods: {
            openPlaylistDetails() {
                this.$store.commit('cache/setSelectedPlaylist', this.playlist);
                this.$router.push(`/my-library/playlists/${this.playlist.name}/${this.playlist.id}`);
            }
        },
        computed: {
            fullResolutionImage() {
                return this.$root.getSpotifyImage(this.playlist, 'medium');
            },
            intermediateImage() {
                return this.$root.getSpotifyImage(this.playlist, 'small');
            }
        }
    }
</script>

<style scoped>
    .no-overflow {
        overflow: hidden;
    }

    .playlist-title {
        text-overflow: fade;
        white-space: nowrap;
        overflow: hidden;
    }

    .playlist-tile.theme--dark {
        background-color: #343434;
        border-color: #343434;
    }
</style>