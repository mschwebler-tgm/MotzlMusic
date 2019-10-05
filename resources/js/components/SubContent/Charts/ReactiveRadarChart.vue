<template>
    <div :id="chartId"></div>
</template>

<script>
    import radarChartConfig from "./radarChartConfig";

    const seriesData = {
        type: Array,
        default: () => [null, null, null, null, null, null],
    };
    const primaryIndex = 1;
    const secondaryIndex = 0;

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
        data() {
            return {
                chart: null,
                randomString: Math.random().toString(36).substring(7),
            }
        },
        created() {
            radarChartConfig.series[0].data = this.secondaryData;
            radarChartConfig.series[0].name = this.secondaryLabel;
            radarChartConfig.series[1].data = this.primaryData;
            radarChartConfig.series[1].name = this.primaryLabel;
        },
        mounted() {
            this.chart = Highcharts.chart(this.chartId, radarChartConfig);
        },
        methods: {
            updateSeries(dataIndex, data) {
                this.chart.series[dataIndex].setData(data);
            },
        },
        watch: {
            primaryData(data) {
                this.updateSeries(primaryIndex, data);
            },
            secondaryData(data) {
                this.updateSeries(secondaryIndex, data);
            },
        },
        computed: {
            chartId() {
                return `radar-chart-${this.randomString}`;
            }
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
