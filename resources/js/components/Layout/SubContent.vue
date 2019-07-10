<template>
    <v-layout column fill-height>
        <v-flex shrink class="pb-0">
            <v-layout justify-end>
                <v-flex shrink>
                    <v-btn flat icon aria-label="Settings">
                        <v-icon>settings</v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>
        </v-flex>
        <v-flex grow fill-height>
            <v-layout column class="fill-height">
                <v-flex shrink class="pt-0">
                    <v-card>
                        <audio-features></audio-features>
                    </v-card>
                </v-flex>
                <v-flex shrink>
                    <v-card>
                        <player-controls></player-controls>
                    </v-card>
                </v-flex>
                <v-flex>
                   <track-info></track-info>
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</template>

<script>
    import AudioFeatures from "../SubContent/AudioFeatures";
    import PlayerControls from "../SubContent/PlayerControls";
    import TrackInfo from "../SubContent/TrackInfo";
    export default {
        name: "SubContent",
        components: {TrackInfo, PlayerControls, AudioFeatures}
    }
</script>

<style scoped>

</style>
