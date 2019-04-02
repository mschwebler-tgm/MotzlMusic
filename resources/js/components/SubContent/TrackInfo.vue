<template>
    <transition name="slideFromTop">
        <v-card v-if="this.currentTrack">
            <div class="d-flex">
                <v-flex shrink class="pa-0" style="flex: 0 !important;">
                    <img :src="imageSrc" width="150" height="150">
                </v-flex>
                <v-flex grow class="d-flex pl-4 justify-center flex-column">
                    <div style="max-width: 180px;">
                        <div class="text-truncate headline">{{ currentTrack.name }}</div>
                        <div class="text-truncate">{{ album.name }}</div>
                        <div>({{ albumDate }})</div>
                    </div>
                    <div class="pt-2">
                        <v-rating v-model="rating"
                                  color="secondary"
                                  background-color="secondary darken2"
                                  :size="24"
                                  dense half-increments hover></v-rating>
                    </div>
                </v-flex>
            </div>
        </v-card>
    </transition>
</template>

<script>
    export default {
        name: "TrackInfo",
        data() {
            return {
                rating: 3.5
            }
        },
        computed: {
            currentTrack() {
                return this.$store.getters['player/playingTrack'];
            },
            imageSrc() {
                return this.currentTrack ? this.currentTrack.album.spotify_image_medium : null;
            },
            album() {
                return this.currentTrack ? this.currentTrack.album : null;
            },
            albumDate() {
                if (!this.album) {
                    return;
                }
                const date = new Date(this.album.release_date);

                return date.getFullYear();
            }
        }
    }
</script>

<style scoped>

    .slideFromTop-enter-active {
        animation: slideFromTop 1s ease-out;
    }

    @keyframes slideFromTop {
        0% {
            -webkit-transform: translate3d(0, -2rem, 0);
            -moz-transform: translate3d(0, -2rem, 0);
            -ms-transform: translate3d(0, -2rem, 0);
            -o-transform: translate3d(0, -2rem, 0);
            transform: translate3d(0, -2rem, 0);
            opacity: 0;
        }
        50% {
            -webkit-transform: translate3d(0, -.5rem, 0);
            -moz-transform: translate3d(0, -.5rem, 0);
            -ms-transform: translate3d(0, -.5rem, 0);
            -o-transform: translate3d(0, -.5rem, 0);
            transform: translate3d(0, -.5rem, 0);
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
</style>
