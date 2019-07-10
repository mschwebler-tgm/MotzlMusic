<template>
    <div id="chart"></div>
</template>

<script>
    import radarChartConfig from "./radarChartConfig";

    const seriesData = {
        type: Array,
        default: () => [null, null, null, null, null, null],
        validator: arr => arr.length === 6,
    };

    export default {
        name: "ReactiveRadarChart",
        props: {
            primaryData: {...seriesData},
            secondaryData: {...seriesData},
            primaryLabel: {
                type: String,
                default: 'Selected tracks (avg)',
            },
            secondaryLabel: {
                type: String,
                default: 'Playing track',
            },
        },
        created() {
            radarChartConfig.series[0].data = this.secondaryData;
            radarChartConfig.series[0].name = this.secondaryLabel;
            radarChartConfig.series[1].data = this.primaryData;
            radarChartConfig.series[1].name = this.primaryLabel;
        },
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
