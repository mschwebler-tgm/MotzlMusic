<template>
    <div id="chart"></div>
</template>

<script>
    import radarChartConfig from "./radarChartConfig";

    export default {
        name: "ReactiveRadarChart",
        mounted() {
            Highcharts.chart('chart', radarChartConfig);
        }
    }
</script>

<style scoped>
    #chart {
        height: 320px;
        width: 320px;
        margin: 0 auto;
    }
</style>
