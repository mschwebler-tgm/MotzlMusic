<template>
    <v-card>
        <transition name="my-library" mode="out-in">
            <router-view></router-view>
        </transition>
    </v-card>
</template>

<script>
    export default {
        name: "MyLibrary",
    }
</script>

<style scoped>
    .my-library-enter-active {
        animation: my-library .2s ease-out;
    }

    .my-library-leave-active {
        animation: my-library .1s reverse ease-in;
    }

    @keyframes my-library {
        0% {
            -webkit-transform: translate3d(1rem, 0, 0);
            -moz-transform: translate3d(1rem, 0, 0);
            -ms-transform: translate3d(1rem, 0, 0);
            -o-transform: translate3d(1rem, 0, 0);
            transform: translate3d(1rem, 0, 0);
            opacity: 0;
        }
        50% {
            opacity: .8;
        }
        100% {
            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
            -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
            opacity: 1;
        }
    }
</style>
