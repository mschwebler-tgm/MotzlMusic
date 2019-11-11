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
            async playingTrack(track) {
                const audioAnalytics = await cacheRequest.getAudioAnalytics(track.id);
                this.playingTrackAudioAnalytics = this.getAudioFeaturesAsArray(audioAnalytics);
            },
            async focusedItems(tracks) {
                if (tracks.length === 1) {
                    const audioAnalytics = await cacheRequest.getAudioAnalytics(tracks[0].id);
                    this.focusedTrackAudioAnalytics = this.getAudioFeaturesAsArray(audioAnalytics);
                }
                // TODO multiple tracks (show avg)
            },
        },
        computed: {
            playingTrack() {
                return this.$store.getters['player/currentTrack'];
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
