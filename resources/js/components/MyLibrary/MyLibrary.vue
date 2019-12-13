<template>
    <div>
        <v-container v-if="!$root.isTouch" class="pa-5 d-flex">
            <h2 class="headline">My Library</h2>
            <v-icon class="ml-2 mr-2" color="grey">chevron_right</v-icon>
            <h3 class="headline grey--text">{{ $route.name }}</h3>
        </v-container>
        <transition name="my-library" mode="out-in">
            <router-view class="pa-3"></router-view>
        </transition>
    </div>
</template>

<script>
    import MainContentHeaders from '../Layout/MainContentHeader/MainContentHeaders';

    export default {
        name: "MyLibrary",
        data() {
            return {
                previousHeader: MainContentHeaders.DEFAULT,
            }
        },
        created() {
            if (this.$root.isTouch) {
                this.$root.mainContentHeaderComponent = MainContentHeaders.MY_LIBRARY;
            }
        },
        destroyed() {
            this.$root.mainContentHeaderComponent = this.previousHeader;
        }
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
