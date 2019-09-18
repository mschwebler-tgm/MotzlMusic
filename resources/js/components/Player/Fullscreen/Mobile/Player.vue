<template>
    <v-expand-transition>
        <div class="fullscreen-player grey darken-4" v-show="show">
            <div id="fullscreen-player-gradient-static" :style="staticGradient">
                <div :style="animatedGradient1" id="fullscreen-player-gradient-1"></div>
                <div :style="animatedGradient2" id="fullscreen-player-gradient-2"></div>
            </div>
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
            backgroundColor: {
                type: String,
                default: '50, 175, 170',
                validator: value => value.split(',').length === 3,
            },
            backgroundColorAccent: {
                type: String,
                default: '#0065a8',
            },
        },
        computed: {
            staticGradient() {
                return {
                    background: `linear-gradient(0deg, rgba(0,0,0, 0) 0%, rgba(${this.backgroundColor}, 0.1) 20%, rgba(${this.backgroundColor}, 0.6) 73%, ${this.backgroundColorAccent} 100%)`,
                }
            },
            animatedGradient1() {
                return {
                    background: `linear-gradient(315deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 40%, rgba(${this.backgroundColor}, 0.6) 100%)`,
                }
            },
            animatedGradient2() {
                return {
                    background: `linear-gradient(315deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 0) 40%, ${this.backgroundColorAccent} 100%)`,
                }
            }
        }
    }
</script>

<style scoped lang="scss">

    .fullscreen-player {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 100%;

        &-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    }

    #fullscreen-player-gradient-static {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;

        #fullscreen-player-gradient-1, #fullscreen-player-gradient-2 {
            position: absolute;
            top: -50vw;
            left: -50vw;
            width: 200vw;
            height: 160vw;
            animation: gradient-animation infinite ease-in-out;
        }

        #fullscreen-player-gradient-1 {
            -webkit-animation-duration: 7s;
            -moz-animation-duration: 7s;
            -o-animation-duration: 7s;
            animation-duration: 7s;
            -webkit-animation-direction: alternate-reverse;
            -moz-animation-direction: alternate-reverse;
            -o-animation-direction: alternate-reverse;
            animation-direction: alternate-reverse;
        }

        #fullscreen-player-gradient-2 {
            -webkit-animation-duration: 5s;
            -moz-animation-duration: 5s;
            -o-animation-duration: 5s;
            animation-duration: 5s;
            -webkit-animation-direction: alternate;
            -moz-animation-direction: alternate;
            -o-animation-direction: alternate;
            animation-direction: alternate;
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
