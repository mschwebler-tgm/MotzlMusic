<template>
    <v-card>
        <div class="d-flex" v-if="this.currentTrack">
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

</style>