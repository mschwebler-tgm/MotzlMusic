<template>
    <div>
        <reactive-radar-chart
            :secondary-data="playingTrackAudioAnalytics"
            :primary-data="focusedTrackAudioAnalytics">
        </reactive-radar-chart>
    </div>
</template>

<script>
    import ReactiveRadarChart from "../Charts/ReactiveRadarChart";
    import cacheRequest from "$scripts/cacheReqest/cacheRequest";

    export default {
        name: "AudioFeatures",
        components: {ReactiveRadarChart},
        data() {
            return {
                playingTrackAudioAnalytics: [0, 0, 0, 0, 0, 0],
                focusedTrackAudioAnalytics: [0, 0, 0, 0, 0, 0],
            }
        },
        watch: {
            async playingTrack(trackId) {
                const audioAnalytics = await cacheRequest.getAudioAnalytics(trackId);
                this.playingTrackAudioAnalytics = this.getAudioFeaturesAsArray(audioAnalytics);
            },
            async focusedItems(items) {
                if (items.length === 0) {
                    this.focusedTrackAudioAnalytics = [0, 0, 0, 0, 0, 0];
                    return;
                }

                const item = items[0];
                let audioAnalytics;
                if (item.id) {
                    audioAnalytics = await cacheRequest.getAudioAnalytics(item.id);
                } else if (item.valence) {  // when hovering a playlist there is no specific track, just avg audio features
                    audioAnalytics = item;
                }
                this.focusedTrackAudioAnalytics = this.getAudioFeaturesAsArray(audioAnalytics);
            },
        },
        computed: {
            playingTrackId() {
                return this.$store.getters['player/currentTrackId'];
            },
            focusedItems() {
                return this.$store.getters['subContent/focusedItems'];
            },
        },
        methods: {
            getAudioFeaturesAsArray(audioFeatures) {
                return [
                    audioFeatures.valence,
                    audioFeatures.danceability,
                    audioFeatures.speechiness,
                    audioFeatures.acousticness,
                    audioFeatures.instrumentalness,
                    audioFeatures.energy,
                ];
            }
        }
    }
</script>
