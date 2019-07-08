<template>
    <div>
        <div class="chart-wrapper" style="display: flex; justify-content: center">
            <base-radar-chart :height="320" :width="320" :data="chartData" ref="chart"></base-radar-chart>
        </div>
    </div>
</template>

<script>
    import BaseRadarChart from "./Charts/BaseRadarChart";

    export default {
        name: "AudioFeatures",
        components: {BaseRadarChart},
        data() {
            return {
                chartData: [],
            }
        },
        watch: {
            playingTrack(track) {
                this.updateTrackData(track);
            }
        },
        methods: {
            updateTrackData(track) {
                if (!track.audio_features) {
                    this.fetchAudioFeatures(track);
                } else {
                    this.setChartData(track.audio_features);
                }
            },
            fetchAudioFeatures(track) {
                axios.get(`/api/track/${track.id}/audio-features`)
                    .then(res => {
                        track.audio_features = res.data;
                        this.setChartData(track.audio_features);
                    });
            },
            setChartData(audioFeatures) {
                this.chartData = [
                    audioFeatures.valence,
                    audioFeatures.danceability,
                    audioFeatures.speechiness,
                    audioFeatures.acousticness,
                    audioFeatures.instrumentalness,
                    audioFeatures.energy,
                ];
                this.$nextTick(() => {
                    this.$refs.chart.draw();
                });
            }
        },
        computed: {
            playingTrack() {
                return this.$store.getters['player/playingTrack'];
            }
        }
    }
</script>

<style scoped>
    .chart-wrapper {
        display: flex;
        justify-content: center;
        padding: 10px 0 20px 0;
    }
</style>
