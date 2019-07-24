<template>
    <v-card tile
            hover
            @click="openPlaylistDetails"
            @mouseenter="showAudioFeatures"
            @mouseleave="hideAudioFeatures"
            class="overlay-play-icon-toggle">
        <div class="relative">
            <v-img
                    :src="fullResolutionImage"
                    :lazy-src="intermediateImage"
                    :alt="playlist.name"
                    aspect-ratio="1">
            </v-img>
            <v-btn fab absolute depressed bottom right small
                   v-if="!isPlaying"
                   @click="playPlaylist"
                   :class="{'force-show': true}"
                   color="secondary"
                   aria-label="Start Playlist"
                   class="overlay-play-icon">
                <v-icon medium>play_arrow</v-icon>
            </v-btn>
            <v-btn icon disabled class="overlay-playing-icon" aria-label="Start Playlist" v-else>
                <v-icon color="white">equalizer</v-icon> <!-- TODO animated SVG? -->
            </v-btn>
        </div>
        <v-card-title primary-title>
            <div class="no-overflow">
                <h4 class="subtitle-1 text-none mb-0 playlist-title">{{ playlist.name }}</h4>
            </div>
        </v-card-title>
    </v-card>
</template>

<script>
    import {slugify} from "../../../helpers";

    export default {
        name: "PlaylistItem",
        props: {
            playlist: Object,
        },
        methods: {
            openPlaylistDetails() {
                this.$store.commit('cache/setSelectedPlaylist', this.playlist);
                this.$router.push(`/my-library/playlists/${slugify(this.playlist.name)}/${this.playlist.id}`);
            },
            playPlaylist($event) {
                $event.stopPropagation();
                this.$store.dispatch('player/playList', {type: 'playlist', list: this.playlist});
            },
            showAudioFeatures() {
                this.$store.commit('subContent/setFocusedItems', [this.playlist]);
            },
            hideAudioFeatures() {
                this.$store.commit('subContent/setFocusedItems', []);
            },
        },
        computed: {
            fullResolutionImage() {
                return this.$root.getSpotifyImage(this.playlist, 'medium');
            },
            intermediateImage() {
                return this.$root.getSpotifyImage(this.playlist, 'small');
            },
            isPlaying() {
                const activeItem = this.$store.getters['player/activeItem'];
                return activeItem.type === 'playlist' && activeItem.id === this.playlist.id;
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