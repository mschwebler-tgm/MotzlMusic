<template>
    <div>
        <gauss :data="data" :labels="labels" ref="chart" :title="label"></gauss>
        Erwartungswert: {{ params.mean }}
        <input type="range" min="0" max="100" :step="stepSize" style="width: 100%" v-model="params.mean"/>
        Standartabweichung: {{ params.stdDev }}
        <input type="range" min="1" max="100" step="1" style="width: 100%" v-model="params.stdDev"/>
    </div>
</template>

<script>
    export default {
        name: "gauss-wrapper",
        props: ['label', 'value'],
        data() {
            return {
                chartData: [],
                params: this.value,  // Standard deviation => Standardabweichung
                stepSize: 5
            }
        },
        created() {
            if (!this.params.stdDev) {
                this.params.stdDev = Math.round(Math.random() * 100);
                this.$emit('input', this.params);
            }
            if (!this.params.mean) {
                this.params.mean = Math.round(Math.random() * 100);
                this.$emit('input', this.params);
            }
        },
        methods: {
            /**
             * @return {number}
             */
            NormalDensity(x) {
                let a = x - this.params.mean;
                let stdDev = this.params.stdDev;
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