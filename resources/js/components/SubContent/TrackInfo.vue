<template>
    <v-card>
        <div class="d-flex">
            <v-flex shrink class="pa-0" style="flex: 0 !important;">
                <img :src="imageSrc" width="150" height="150">
            </v-flex>
            <v-flex grow class="d-flex pl-4 justify-center flex-column">
                <div>
                    <div class="headline">Supermodel</div>
                    <div>Foster the People</div>
                    <div>(2014)</div>
                </div>
                <div class="pt-2">
                    <v-icon style="font-size: 20px">star</v-icon>
                    <v-icon style="font-size: 20px">star</v-icon>
                    <v-icon style="font-size: 20px">star</v-icon>
                    <v-icon style="font-size: 20px">star_half</v-icon>
                    <v-icon style="font-size: 20px">star_border</v-icon>
                </div>
            </v-flex>
        </div>
    </v-card>
</template>

<script>
    export default {
        name: "TrackInfo",
        computed: {
            currentTrack() {
                return this.$store.getters['player/playingTrack'];
            },
            imageSrc() {
                return this.currentTrack ? this.currentTrack.album.spotify_image_medium : null;
            }
        }
    }
</script>

<style scoped>

</style>