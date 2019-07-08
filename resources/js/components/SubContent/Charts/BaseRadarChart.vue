<script>
    import {mixins, Radar} from 'vue-chartjs';
    import theme from '../../../theme';
    import {hexToRgba} from '../../../helpers/colorsTransform'

    const {reactiveProp} = mixins;

    const chartOptions = {
        legend: {
            display: false,
        },
        tooltips: {
            callbacks: {
                label: (tooltipItem, data) => {
                    let label = data.datasets[tooltipItem.datasetIndex].label || '';

                    if (label) {
                        label += ': ';
                    }
                    label += Math.round(tooltipItem.yLabel * 100) / 100;
                    return label;
                }
            },
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            borderColor: hexToRgba(theme.secondary, 1),
            borderWidth: 1,
            cornerRadius: 1,
            displayColors: false,
        },
        scale: {
            ticks: {
                display: false,
                min: 0,
                max: 1,
                stepSize: 0.2,
            },
            angleLines: {
                color: 'rgba(128, 128, 128, 0.5)',
            },
            gridLines: {
                color: hexToRgba(theme.secondary, .2),
                borderDash: [15, 3, 3, 3],
            },
            pointLabels: {
                fontColor: '#808080',
                fontSize: 12
            }
        },
    };

    export default {
        props: {
            chartData: Object,
            playingTrack: Array,
            focusedTracks: Array,
        },
        name: "BaseRadarChart",
        extends: Radar,
        mixins: [reactiveProp],
        mounted() {
            this.draw();
        },
        methods: {
            draw() {

                this.renderChart(
                    this.chartData,
                    chartOptions
                );
            }
        }
    }
</script>

<style scoped>

</style>
