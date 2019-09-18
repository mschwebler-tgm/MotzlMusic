<template>
    <v-expand-transition>
        <div class="fullscreen-player grey darken-4" v-show="show">
            <div class="fullscreen-player-gradient"></div>
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

        &-gradient {
            position: absolute;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(0deg, rgba(0,0,0, 0) 0%, rgba(50, 175, 170, 0.1) 20%, rgba(50, 175, 170, 0.6) 73%, #0065a8 100%);

            &::before {
                content: "";
                position: absolute;
                top: -50vw;
                left: -50vw;
                width: 200vw;
                height: 160vw;
                background: linear-gradient(315deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 40%, rgba(50, 175, 170, 0.6) 100%);
                animation: gradient-animation alternate-reverse 7s infinite ease-in-out;
            }

            &::after {
                content: "";
                position: absolute;
                top: -50vw;
                left: -50vw;
                width: 200vw;
                height: 160vw;
                background: linear-gradient(315deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 40%, #0065a8 100%);
                animation: gradient-animation alternate 5s infinite ease-in-out;
            }
        }

        &-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    }

    @keyframes gradient-animation {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(95deg);
        }
    }
</style>
