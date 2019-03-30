<template>
    <div>
        <v-card-title>
            <span class="headline">Audio Features</span>
        </v-card-title>

        <div class="chart-wrapper" style="display: flex; justify-content: center">
            <base-radar-chart :height="320" :width="320"></base-radar-chart>
        </div>
    </div>
</template>

<script>
    import BaseRadarChart from "./Charts/BaseRadarChart";

    export default {
        name: "AudioFeatures",
        components: {BaseRadarChart}
    }
</script>

<style scoped>
    .chart-wrapper {
        display: flex;
        justify-content: center;
        padding: 10px 0 20px 0;
    }
</style>
