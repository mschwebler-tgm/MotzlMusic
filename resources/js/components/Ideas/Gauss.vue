<script>
    import {Line} from 'vue-chartjs';

    export default {
        name: "gauss",
        props: ['data', 'labels'],
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
                            label: 'Energy',
                            // backgroundColor: 'rgba(248, 121, 121, .1)',
                            borderColor: '#17a089',
                            data: this.data
                        }
                    ]
                }, {responsive: true, maintainAspectRatio: false});
            }
        }
    }
</script>

<style scoped>

</style>