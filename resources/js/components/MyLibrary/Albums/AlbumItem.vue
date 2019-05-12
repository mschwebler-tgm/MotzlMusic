<template>
    <v-card tile
            hover
            @click="openAlbumDetails"
            class="overlay-play-icon-toggle">
        <div class="relative">
            <v-img
                    :src="fullResolutionImage"
                    :lazy-src="intermediateImage"
                    :alt="album.name"
                    aspect-ratio="1">
            </v-img>
            <v-btn icon fab absolute bottom right small
                   v-if="!isPlaying"
                   @click="playAlbum"
                   :class="{'force-show': $root.isTouch}"
                   color="secondary"
                   class="overlay-play-icon">
                <v-icon medium>play_arrow</v-icon>
            </v-btn>
            <v-btn icon disabled class="overlay-playing-icon" v-else>
                <v-icon color="white">equalizer</v-icon> <!-- TODO animated SVG? -->
            </v-btn>
        </div>
        <v-card-title primary-title>
            <div class="no-overflow">
                <h4 class="subheading mb-0 album-title">{{ album.name }}</h4>
                <span class="caption grey--text">{{ album.tracks.length }} track{{ album.tracks.length > 1 ? 's' : '' }}</span>
            </div>
        </v-card-title>
    </v-card>
</template>

<script>
    export default {
        name: "AlbumItem",
        props: {
            album: Object,
        },
        methods: {
            openAlbumDetails() {
                this.$store.commit('cache/setSelectedAlbum', this.album);
                this.$router.push(`/my-library/albums/${this.album.name}/${this.album.id}`);
            },
            playAlbum($event) {
                $event.stopPropagation();
                this.$store.dispatch('player/playAlbum', this.album);
            },
        },
        computed: {
            fullResolutionImage() {
                return this.$root.getSpotifyImage(this.album, 'medium');
            },
            intermediateImage() {
                return this.$root.getSpotifyImage(this.album, 'small');
            },
            isPlaying() {
                return this.$store.getters['player/activeAlbumId'] === this.album.id;
            }
        }
    }
</script>

<style scoped>
    .no-overflow {
        overflow: hidden;
    }

    .album-title {
        text-overflow: fade;
        white-space: nowrap;
        overflow: hidden;
    }

    .album-tile.theme--dark {
        background-color: #343434;
        border-color: #343434;
    }

    .overlay-playing-icon {
        position: absolute !important;
        bottom: 0;
        right: 0;
        background-color: rgba(0, 0, 0, 0.42);
    }

    .overlay-play-icon {
        display: none;
    }

    .overlay-play-icon-toggle:hover .overlay-play-icon {
        display: block;
    }
</style>