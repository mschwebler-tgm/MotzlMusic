<template>
    <v-flex>
        <v-layout column>
            <v-flex grow>
                <v-layout justify-center>
                    <v-flex shrink>
                        <v-btn text icon aria-label="Play previous" :disabled="noPreviousTrack">
                            <v-icon @click="playPrevious">skip_previous</v-icon>
                        </v-btn>
                        <v-btn text icon :loading="loading" @click="togglePlay"
                               :aria-label="playing ? 'Pause' : 'Play'">
                            <v-icon large class="secondary--text" v-if="playing">pause_circle_filled</v-icon>
                            <v-icon large class="secondary--text" v-else>play_circle_filled</v-icon>
                        </v-btn>
                        <v-btn text icon aria-label="Play next" :disabled="noNextTrack">
                            <v-icon @click="playNext">skip_next</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex class="secondary d-flex gradient">
                <v-flex grow class="pa-0 pr-3 text-truncate">
                    <span class="body-2">{{ title }}</span>
                    <br>
                    <span class="caption">{{ artists }}</span>
                </v-flex>
                <v-flex shrink class="pa-0 d-flex align-center" style="flex: 0 !important;">
                    <v-progress-circular :value="progressPercent"></v-progress-circular>
                </v-flex>
            </v-flex>
        </v-layout>
    </v-flex>
</template>

<script>
    import player from "$store/player/helpers/v2/player";
    import playerControlsMixin from "../Player/playerControlsMixin";
    import Vue from 'vue';

    export default Vue.extend({
        name: "PlayerControls",
        mixins: [playerControlsMixin],
        computed: {
            progressPercent() {
                return player.progressPercent;
            },
        }
    });
</script>

<style scoped>
    .track-progress {
        position: absolute;
        right: 12px;
        bottom: 12px
    }

    .gradient {
        background: -moz-linear-gradient(-90deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.20) 100%);
        background: -webkit-linear-gradient(-90deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.20) 100%);
        background: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0.20) 100%);
        filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#00000000', endColorstr='#54000000', GradientType=1);
    }

</style>
