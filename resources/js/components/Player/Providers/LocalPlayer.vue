<template>
    <audio ref="audio"/>
</template>

<script>
    import player from '$store/player/helpers/v2/player';
    import LocalProvider from "$store/player/helpers/v2/providers/LocalProvider";

    export default {
        name: "LocalPlayer",
        mounted() {
            const localProvider = new LocalProvider(this.$refs.audio);
            player.addProvider(localProvider);
        }
    }
</script>
