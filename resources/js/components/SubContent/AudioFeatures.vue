<template>
    <div>
        <reactive-radar-chart
                :secondary-data="primaryData">
        </reactive-radar-chart>
    </div>
</template>

<script>
    import ReactiveRadarChart from "./Charts/ReactiveRadarChart";

    export default {
        name: "AudioFeatures",
        components: {ReactiveRadarChart},
        watch: {
            playingTrack() {
                this._fetchAudioFeaturesIfNecessary([this.playingTrack]);
            },
        },
        methods: {
            _fetchAudioFeaturesIfNecessary(tracks) {
                const promises = tracks
                    .filter(track => !track.audio_features)
                    .map(track => {
                        return axios.get(`/api/track/${track.id}/audio-features`)
                            .then(res => track.audio_features = res.data);
                    });

                return Promise.all(promises);
            },
        },
        computed: {
            playingTrack() {
                return this.$store.getters['player/playingTrack'];
            },
            focusedTracks() {
                return this.$store.getters['subContent/focusedTracks'];
            },
            primaryData() {
                if (!this.playingTrack || !this.playingTrack.audio_features) {
                    return [0, 0, 0, 0, 0, 0];
                }
                const audioFeatures = this.playingTrack.audio_features;

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

<style scoped>

</style>
