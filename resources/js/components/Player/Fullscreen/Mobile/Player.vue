<template>
    <v-expand-transition>
        <div class="fullscreen-player grey darken-4" v-show="show">
            <v-container>
                <div class="fullscreen-player-header">
                    <v-btn text icon @click="$emit('update:show', false)">
                        <v-icon large>keyboard_arrow_down</v-icon>
                    </v-btn>
                    <v-btn text icon>
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </div>
            </v-container>
        </div>
    </v-expand-transition>
</template>

<script>
    export default {
        name: "PlayerFullscreenMobile",
        props: {
            show: Boolean,
        }
    }
</script>

<style scoped lang="scss">
    .fullscreen-player {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100vw;
        height: 100vh;

        &-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    }
</style>
