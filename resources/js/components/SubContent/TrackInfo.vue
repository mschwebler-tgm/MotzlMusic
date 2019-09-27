<template>
    <div class="d-flex">
        <v-flex shrink class="pa-0" style="flex: 0 !important;">
            <v-img :src="albumCover" contain width="150" height="150" :alt="albumDate"></v-img>
        </v-flex>
        <v-flex grow class="d-flex pl-4 justify-center flex-column">
            <div style="max-width: 180px;">
                <div class="text-truncate headline">{{ title }}</div>
                <div class="text-truncate">{{ albumName }}</div>
                <div>{{ albumDate ? `(${albumDate})` : ''}}</div>
            </div>
            <div class="pt-2">
                <v-rating v-model="rating"
                          @input="updateRating"
                          color="secondary"
                          background-color="secondary darken2"
                          :size="24"
                          :readonly="!currentTrack"
                          dense half-increments hover></v-rating>
            </div>
        </v-flex>
    </div>
</template>

<script>
    import playerControlsMixin from "$components/components/Player/playerControlsMixin";
    import Vue from 'vue';

    export default Vue.extend({
        name: "TrackInfo",
        mixins: [playerControlsMixin],
        data() {
            return {
                rating: null,
            }
        },
        methods: {
            updateRating() {
                this.$store.dispatch('tracks/rateTrack', {track: this.currentTrack, rating: this.rating});
            }
        },
        watch: {
            currentTrack(newTrack) {
                if (newTrack) {
                    this.rating = newTrack.rating;
                }
            },
        },
        computed: {
            albumDate() {
                if (!this.album) {
                    return null;
                }
                const date = new Date(this.album.release_date);

                return date.getFullYear();
            }
        }
    });
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
