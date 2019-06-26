<template>
    <base-track-table
            :tracks="tracks"
            :renderFunction="renderFunction"
            :height="height"
            @track-selected="playTrack">
    </base-track-table>
</template>

<script>
    import BaseTrackTable from "./BaseTrackTable";

    export default {
        name: "TrackTable",
        components: {BaseTrackTable},
        props: {
            tracks: Array,
            renderFunction: Function,
            height: String,
        },
        methods: {
            playTrack(track) {
                this.$store.dispatch('player/play', track);
                this.$store.commit('player/setQueue', this.tracks);
                this.$store.commit('player/setQueueTrack', track);
            }
        },
    }
</script>
