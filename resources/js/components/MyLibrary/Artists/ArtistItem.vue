<template>
    <v-card tile
            hover
            @click="openArtistDetails"
            class="overlay-play-icon-toggle">
        <div class="relative">
            <v-img
                    :src="fullResolutionImage"
                    :lazy-src="intermediateImage"
                    :alt="artist.name"
                    aspect-ratio="1">
            </v-img>
            <v-btn icon fab absolute bottom right small
                   v-if="!isPlaying"
                   @click="playArtist"
                   :class="{'force-show': $root.isTouch}"
                   color="secondary"
                   aria-label="Play"
                   class="overlay-play-icon">
                <v-icon medium>play_arrow</v-icon>
            </v-btn>
            <v-btn icon disabled class="overlay-playing-icon" aria-label="Playing" v-else>
                <v-icon color="white">equalizer</v-icon> <!-- TODO animated SVG? -->
            </v-btn>
        </div>
        <v-card-title primary-title>
            <div class="no-overflow">
                <h4 class="subheading mb-0 artist-title">{{ artist.name }}</h4>
                <span class="caption grey--text">{{ artist.tracks.length }} track{{ artist.tracks.length > 1 ? 's' : '' }}</span>
            </div>
        </v-card-title>
    </v-card>
</template>

<script>
    export default {
        name: "ArtistItem",
        props: {
            artist: Object,
        },
        methods: {
            openArtistDetails() {
                this.$store.commit('cache/setSelectedAlbum', this.artist);
                this.$router.push(`/my-library/artists/${this.artist.name}/${this.artist.id}`);
            },
            playArtist($event) {
                $event.stopPropagation();
                this.$store.dispatch('player/playList', {type: 'artist', list: this.artist});
            },
        },
        computed: {
            fullResolutionImage() {
                return this.$root.getSpotifyImage(this.artist, 'medium');
            },
            intermediateImage() {
                return this.$root.getSpotifyImage(this.artist, 'small');
            },
            isPlaying() {
                const activeItem = this.$store.getters['player/activeItem'];
                return activeItem.type === 'artist' && activeItem.id === this.artist.id;
            }
        }
    }
</script>

<style scoped>
    .no-overflow {
        overflow: hidden;
    }

    .artist-title {
        text-overflow: fade;
        white-space: nowrap;
        overflow: hidden;
    }

    .artist-tile.theme--dark {
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