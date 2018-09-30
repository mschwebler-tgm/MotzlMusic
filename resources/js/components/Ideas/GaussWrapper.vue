<template>
    <div>
        <gauss :data="data" :labels="labels" ref="chart"></gauss>
    </div>
</template>

<script>
    export default {
        name: "gauss-wrapper",
        data() {
            return {
                chartData: [],
                stdDev: 20,  // Standard deviation => Standardabweichung
                mean: 80  // => Erwartungswert
            }
        },
        methods: {
            /**
             * @return {number}
             */
            NormalDensity(x) {
                let a = x - this.mean;
                let stdDev = this.stdDev;
                return Math.exp(-(a * a) / (2 * stdDev * stdDev)) / (Math.sqrt(2 * Math.PI) * stdDev);
            }
        },
        computed: {
            data() {
                let data = [];
                for (let x = 0; x <= 100; x += 1) {
                    data.push(this.NormalDensity(x))
                }
                this.chartData = data;
                return data;
            },
            labels: {
                get() {
                    let labels = [];
                    // this.chartData.forEach(() => labels.push(Math.round((x++ * 100 / this.chartData.length) * 10) / 10));
                    this.chartData.forEach(() => labels.push(''));
                    return labels;
                },
                set() {

                }
            }
        }
    }
</script>

<style scoped>

</style>