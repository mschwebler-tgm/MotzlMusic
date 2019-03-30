<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-layout column fill-height>
        <v-flex shrink class="pb-0">
            <v-layout justify-end>
                <v-flex shrink>
                    <v-btn flat icon>
                        <v-icon>settings</v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>
        </v-flex>
        <v-flex grow fill-height>
            <v-layout column>
                <v-flex class="pt-0">
                    <v-card>
                        <audio-features></audio-features>
                    </v-card>
                </v-flex>
                <v-flex>
                    <v-card>
                        <v-card-title>
                            <span class="headline">Analysis</span>
                        </v-card-title>
                    </v-card>
                </v-flex>
                <v-flex>
                    <v-card>
                        <v-card-title>
                            <span class="headline">Analysis</span>
                        </v-card-title>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</template>

<script>
    import BaseRadarChart from "../SubContent/Charts/BaseRadarChart";
    import AudioFeatures from "../SubContent/AudioFeatures";
    export default {
        name: "SubContent",
        components: {AudioFeatures, BaseRadarChart}
    }
</script>

<style scoped>

</style>
