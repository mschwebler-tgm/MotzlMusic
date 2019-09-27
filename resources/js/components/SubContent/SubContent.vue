<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-layout column fill-height>
        <v-flex shrink class="pb-0">
            <v-layout justify-end>
                <v-flex shrink>
                    <v-tooltip left>
                        <template v-slot:activator="{ on }">
                            <v-btn text icon v-on="on"
                                   @click="$root.subContentEditModeActive = !$root.subContentEditModeActive"
                                   aria-label="Settings" class="mt-2 mb-3">
                                <v-icon>settings</v-icon>
                            </v-btn>
                        </template>
                        <span>Configure Sub Content</span>
                    </v-tooltip>
                </v-flex>
            </v-layout>
        </v-flex>
        <v-flex grow fill-height>
            <v-layout column class="fill-height">
                <v-flex v-for="(content, index) in subContent"
                        :key="content.component"
                        shrink
                        :class="{'pt-0': index === 0}">
                    <v-card>
                        <component :is="content.component"></component>
                        <v-overlay :value="$root.subContentEditModeActive" absolute color="primary"></v-overlay>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</template>

<script>
    import AudioFeatures from "./Components/AudioFeatures";
    import PlayerControls from "./Components/PlayerControls";
    import TrackInfo from "./Components/TrackInfo";

    export default {
        name: "SubContent",
        components: {TrackInfo, PlayerControls, AudioFeatures},
        data() {
            return {
                subContent: [
                    {
                        component: 'audio-features',
                    },
                    {
                        component: 'player-controls',
                    },
                    {
                        component: 'track-info',
                    },
                ],
            }
        },
    }
</script>

<style scoped>

</style>
