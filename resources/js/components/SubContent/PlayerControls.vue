<template>
    <v-flex>
        <v-layout column>
            <v-flex>Title</v-flex>
            <v-flex grow>
                <v-layout justify-center>
                    <v-flex shrink>
                        <v-btn flat icon>
                            <v-icon>skip_previous</v-icon>
                        </v-btn>
                        <v-btn flat icon>
                            <v-icon large class="primary--text">pause_circle_filled</v-icon>
                        </v-btn>
                        <v-btn flat icon>
                            <v-icon>skip_next</v-icon>
                        </v-btn>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-flex class="primary">Footer</v-flex>
        </v-layout>
    </v-flex>
</template>

<script>
    export default {
        name: "PlayerControls",
        computed: {
            title() {
                return 'No track';
            },
        }
    }
</script>

<style scoped>

</style>
