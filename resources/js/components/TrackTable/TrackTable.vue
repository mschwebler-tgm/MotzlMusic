<template>
    <base-track-table
            :tracks="tracks"
            :renderFunction="renderFunction"
            :height="height">
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
    }
</script>
