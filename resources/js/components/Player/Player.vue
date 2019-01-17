<template>
    <div>
        <spotify-player></spotify-player>
    </div>
</template>

<script>
    import SpotifyPlayer from "./Spotify/SpotifyPlayer";
    import PlayerController from "../../store/modules/player/helpers";
    export default {
        name: "Player",
        components: {SpotifyPlayer},
        mounted() {
            const playerController = new PlayerController(this.$store);
            this.$store.commit('player/setPlayerController', playerController)
        }
    }
</script>

<style scoped>

</style>
