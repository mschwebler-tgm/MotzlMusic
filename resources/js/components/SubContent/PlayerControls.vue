<template>
    <v-flex>
        <v-layout column>
            <v-flex>Progress</v-flex>
            <v-flex grow>
                <v-layout justify-center>
                    <v-flex shrink>
                        <v-btn flat icon>
                            <v-icon>skip_previous</v-icon>
                        </v-btn>
                        <v-btn flat icon :loading="loading">
                            <v-icon large class="primary--text" v-if="playing">pause_circle_filled</v-icon>
                            <v-icon large class="primary--text" v-else>play_circle_filled</v-icon>
                        </v-btn>
                        <v-btn flat icon>
                            <v-icon>skip_next</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex class="primary text-truncate">{{ title }}</v-flex>
        </v-layout>
    </v-flex>
</template>

<script>
    export default {
        name: "PlayerControls",
        computed: {
            title() {
                return this.currentTrack ? this.currentTrack.name : 'No track';
            },
            playing() {
                return this.$store.getters['player/playing'];
            },
            currentTrack() {
                return this.$store.getters['player/playingTrack'];
            },
            loading() {
                return this.$store.getters['player/loading']
            }
        }
    }
</script>

<style scoped>

</style>
