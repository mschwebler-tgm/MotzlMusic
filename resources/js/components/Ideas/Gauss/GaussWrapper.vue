<template>
    <div>
        <gauss :data="data" :labels="labels" ref="chart"></gauss>
        Erwartungswert: {{ mean }}
        <input type="range" min="0" max="100" :step="stepSize" style="width: 100%" v-model="mean"/>
        Standartabweichung: {{ stdDev }}
        <input type="range" min="1" max="100" step="1" style="width: 100%" v-model="stdDev"/>
    </div>
</template>

<script>
    export default {
        name: "gauss-wrapper",
        data() {
            return {
                chartData: [],
                stdDev: 20,  // Standard deviation => Standardabweichung
                mean: 100,  // => Erwartungswert
                stepSize: 5
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
                    let x = 0;
                    this.chartData.forEach(() => {
                        // step += this.stepSize;
                        x++;
                        if (x % this.stepSize === 0) {
                            labels.push(x);
                        } else {
                            labels.push('')
                        }
                    });
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