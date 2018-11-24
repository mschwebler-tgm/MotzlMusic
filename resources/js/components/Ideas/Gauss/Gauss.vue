<script>
    import {Line} from 'vue-chartjs';

    export default {
        name: "gauss",
        props: ['data', 'labels', 'title'],
        extends: Line,
        mounted () {
            this.drawChart();
        },
        watch: {
            data() {
                this.drawChart();
            }
        },
        methods: {
            drawChart() {
                this.renderChart({
                    labels: this.labels,
                    datasets: [
                        {
                            label: this.title,
                            backgroundColor: 'rgba(121, 121, 121, .1)',
                            borderColor: '#17a089',
                            data: this.data,
                            pointBorderColor: "rgba(0,0,0,0)",
                            pointBackgroundColor: "rgba(0,0,0,0)",
                            pointRadius: 0,
                            pointHitRadius: 0,
                            pointHoverRadius: 0
                        }
                    ]
                },
                {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false,
                    scales: {
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                            },
                            ticks: {
                                beginAtZero: true,
                                display: false
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false,
                            },
                        }],
                    },
                });
            }
        }
    }
</script>

<style scoped>

</style>