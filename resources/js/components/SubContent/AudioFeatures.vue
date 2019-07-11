<template>
    <div>
        <reactive-radar-chart
                :secondary-data="secondaryData"
                :primary-data="primaryData">
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
            getAudioFeaturesAsArray(track) {
                if (!track || !track.audio_features) {
                    return [0, 0, 0, 0, 0, 0];
                }
                const audioFeatures = track.audio_features;

                return [
                    audioFeatures.valence,
                    audioFeatures.danceability,
                    audioFeatures.speechiness,
                    audioFeatures.acousticness,
                    audioFeatures.instrumentalness,
                    audioFeatures.energy,
                ];
            }
        },
        computed: {
            playingTrack() {
                return this.$store.getters['player/playingTrack'];
            },
            focusedItems() {
                return this.$store.getters['subContent/focusedItems'];
            },
            secondaryData() {
                return this.getAudioFeaturesAsArray(this.playingTrack);
            },
            primaryData() {
                // noinspection JSPotentiallyInvalidTargetOfIndexedPropertyAccess
                return this.getAudioFeaturesAsArray(this.focusedItems.length > 0 ? this.focusedItems[0] : null);
            }
        }
    }
</script>

<style scoped>

</style>
