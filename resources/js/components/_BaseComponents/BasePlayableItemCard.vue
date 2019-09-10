<template>
    <v-card tile
            :hover="!rounded"
            :flat="rounded"
            @click="openItemDetails"
            @mouseenter="showAudioFeatures"
            @mouseleave="hideAudioFeatures"
            class="overlay-play-icon-toggle">
        <div class="relative">
            <v-img
                    :class="{'image-rounded': rounded}"
                    :src="fullResolutionImage"
                    :lazy-src="intermediateImage"
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

    export default {
        name: "BasePlayableItemCard",
        props: {
            item: Object,
            rounded: Boolean,
        },
        methods: {
            openItemDetails() {
                const typeCapitalized = this.item.type.charAt(0).toUpperCase() + this.item.type.slice(1);
                this.$store.commit(`cache/setSelected${typeCapitalized}`, this.item);
                this.$router.push(`/my-library/${this.item.type}/${slugify(this.item.name)}/${this.item.id}`);
            },
            playItem($event) {
                $event.stopPropagation();
                if (!this.item.tracks) {
                    player.forceLoading(true);
                    axios.get(`/api/${this.item.type}/${this.item.id}/tracks`)
                        .then(res => this.item.tracks = res.data)
                        .then(() => player.playList(this.item.tracks))
                        .finally(() => player.forceLoading(false));
                } else {
                    player.playList(this.item.tracks);
                }
            },
            showAudioFeatures() {
                this.$store.commit('subContent/setFocusedItems', [this.item]);
            },
            hideAudioFeatures() {
                this.$store.commit('subContent/setFocusedItems', []);
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

    .image-rounded {
        -webkit-border-radius: 100%;
        -moz-border-radius: 100%;
        border-radius: 100%;
        overflow: hidden;
    }
</style>
