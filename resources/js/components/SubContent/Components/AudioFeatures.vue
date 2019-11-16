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
            playingTrackId: {
                async handler(trackId) {
                    if (!trackId) {
                        return;
                    }

                    const audioAnalytics = await cacheRequest.getAudioAnalyticsForTrackId(trackId);
                    this.playingTrackAudioAnalytics = this.getAudioFeaturesAsArray(audioAnalytics);
                },
                immediate: true,
            },
            async audioFeaturesUrl(url) {
                if (!url) {
                    this.focusedTrackAudioAnalytics = [0, 0, 0, 0, 0, 0];
                    return;
                }

                const audioFeatures = await cacheRequest.getAudioAnalytics(url);
                this.focusedTrackAudioAnalytics = this.getAudioFeaturesAsArray(audioFeatures);
            },
        },
        computed: {
            playingTrackId() {
                return this.$store.getters['player/currentTrackId'];
            },
            audioFeaturesUrl() {
                return this.$store.getters['subContent/audioFeaturesUrl'];
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
