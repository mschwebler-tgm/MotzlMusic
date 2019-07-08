<template>
    <div>
        <div class="chart-wrapper" style="display: flex; justify-content: center">
            <base-radar-chart :height="320" :width="320" :chart-data="chartData" ref="chart" v-if="shouldShowChart"></base-radar-chart>
        </div>
    </div>
</template>

<script>
    import BaseRadarChart from "./Charts/BaseRadarChart";
    import {hexToRgba} from "../../helpers/colorsTransform";
    import theme from "../../theme";

    export default {
        name: "AudioFeatures",
        components: {BaseRadarChart},
        data() {
            return {
                chartDataSets: {
                    playingTrack: [],
                    focusedTracks: [],
                },
            }
        },
        watch: {
            playingTrack() {
                this.updatePlayingTrackData();
            },
            focusedTracks() {
                this.updateFocusedTracksData();
            },
        },
        methods: {
            updatePlayingTrackData() {
                this._fetchAudioFeaturesIfNecessary([this.playingTrack])
                    .then(() => this.setPlayingTrackChartData());
            },
            _fetchAudioFeaturesIfNecessary(tracks) {
                const promises = tracks
                    .filter(track => !track.audio_features)
                    .map(track => {
                        return axios.get(`/api/track/${track.id}/audio-features`)
                            .then(res => track.audio_features = res.data);
                    });

                return Promise.all(promises);
            },
            setPlayingTrackChartData() {
                let audioFeatures = this.playingTrack.audio_features;
                this.chartDataSets.playingTrack = [
                    audioFeatures.valence,
                    audioFeatures.danceability,
                    audioFeatures.speechiness,
                    audioFeatures.acousticness,
                    audioFeatures.instrumentalness,
                    audioFeatures.energy,
                ];
                // this.$nextTick(() => {
                //     this.$refs.chart.draw();
                // });
            },
            updateFocusedTracksData() {
                if (!this._shouldDrawFocusedTrackData()) {
                    this.chartDataSets.focusedTracks = [];
                    // this.$nextTick(() => {
                    //     this.$refs.chart.draw();
                    // });
                    return;
                }

                this._fetchAudioFeaturesIfNecessary(this.focusedTracks).then(() => {
                    const avgAudioFeatures = {
                        valence: [],
                        danceability: [],
                        speechiness: [],
                        acousticness: [],
                        instrumentalness: [],
                        energy: [],
                    };
                    this.focusedTracks.map(track => track.audio_features).forEach(audioFeatures => {
                        // add every single audio feature to array of accumulated audio features (avgAudioFeatures)
                        Object.keys(avgAudioFeatures).forEach(key => avgAudioFeatures[key].push(audioFeatures[key]));
                    });

                    // calculate average for each audio feature
                    Object.keys(avgAudioFeatures).forEach(key => {
                        avgAudioFeatures[key] = avgAudioFeatures[key].reduce((a, b) => a + b, 0) / avgAudioFeatures[key].length;
                    });

                    this.chartDataSets.focusedTracks = Object.values(avgAudioFeatures);

                    // this.$nextTick(() => {
                    //     this.$refs.chart.draw();
                    // });
                });

            },
            _shouldDrawFocusedTrackData() {
                // noinspection JSPotentiallyInvalidTargetOfIndexedPropertyAccess
                const onlyFocusedTrackIsPlayingTrack = this.focusedTracks.length === 1 && this.playingTrack &&
                    this.focusedTracks[0].id === this.playingTrack.id;
                const preventDraw = this.focusedTracks.length === 0 || onlyFocusedTrackIsPlayingTrack;

                return !preventDraw;
            }
        },
        computed: {
            playingTrack() {
                return this.$store.getters['player/playingTrack'];
            },
            focusedTracks() {
                return this.$store.getters['subContent/focusedTracks'];
            },
            chartData() {
                return {
                    labels: ['Happy', 'Dance', 'Speech', 'Acoustic', 'Instruments', 'Energy'],
                    datasets: [
                        {
                            label: 'Focused tracks',
                            backgroundColor: hexToRgba(theme.primary, .5),
                            borderColor: theme.primary,
                            borderWidth: 2,
                            pointRadius: 2,
                            pointHitRadius: 20,
                            data: this.chartDataSets.focusedTracks,
                        },
                        {
                            label: 'Current track',
                            backgroundColor: hexToRgba(theme.secondary, .5),
                            borderColor: theme.secondary,
                            borderWidth: 2,
                            pointRadius: 2,
                            pointHitRadius: 20,
                            data: this.chartDataSets.playingTrack,
                        },
                    ]
                }
            },
            shouldShowChart() {  // bug in vue-chartjs: when no initial data is available, animations are not working
                return this.chartData.datasets.reduce((total, dataset) => total + dataset.data.length, 0) > 0;
            },
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
