<template>
    <v-card tile
            :hover="!rounded"
            :flat="rounded"
            @click="openItemDetails"
            @mouseenter="showAudioFeatures"
            @mouseleave="hideAudioFeatures"
            class="overlay-play-icon-toggle">
        <div class="relative">
            <v-img :class="{'image-rounded': rounded}"
                   :src="fullResolutionImage"
                   :alt="item.name"
                   aspect-ratio="1">
            </v-img>
            <v-btn fab absolute depressed bottom right small
                   v-if="!isPlaying"
                   @click="playItem"
                   :class="{'force-show': $root.isTouch}"
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
                <h4 class="subtitle-1 text-none mb-0 item-title">{{ item.name }}</h4>
                <slot name="footer"></slot>
            </div>
        </v-card-title>
    </v-card>
</template>

<script>
    import {slugify} from "../../helpers";
    import player from "$store/player/helpers/v2/player";
    import cacheRequest from "$scripts/cacheReqest/cacheRequest";

    export default {
        name: "BasePlayableItemCard",
        props: {
            item: Object,
            rounded: Boolean,
        },
        methods: {
            openItemDetails() {
                if (this.item.type === 'playlist') {
                    this.$store.commit(`cache/setSelectedPlaylist`, this.item);
                }
                this.$router.push(`/my-library/${this.item.type}/${slugify(this.item.name)}/${this.item.id}`);
            },
            async playItem($event) {
                $event.stopPropagation();
                player.forceLoading(true);
                const trackIds = this.item.tracks.map(track => track.id);
                const tracks = await cacheRequest.getTracks(trackIds, this.item.tracks_url);
                player.playList(tracks);
                player.forceLoading(false);
            },
            showAudioFeatures() {
                this.$store.commit('subContent/setAudioFeatures', this.item.audio_features_url);
            },
            hideAudioFeatures() {
                this.$store.commit('subContent/setAudioFeatures', null);
            },
        },
        computed: {
            fullResolutionImage() {
                return this.$root.getSpotifyImage(this.item, 'medium');
            },
            intermediateImage() {
                return this.$root.getSpotifyImage(this.item, 'small');
            },
            isPlaying() {
                // const activeItem = this.$store.getters['player/activeItem'];
                // return activeItem.type === this.item.type && activeItem.id === this.item.id;
                // TODO active item
            }
        },

    }
</script>

<style scoped>
    .no-overflow {
        overflow: hidden;
    }

    .item-title {
        text-overflow: fade;
        white-space: nowrap;
        overflow: hidden;
    }

    .item-tile.theme--dark {
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
