<template>
    <div>
        <spotify-player></spotify-player>
    </div>
</template>

<script>
    import SpotifyPlayer from "./Spotify/SpotifyPlayer";
    import PlayerController from "../../store/modules/player/helpers/PlayerController";

    export default {
        name: "Player",
        components: {SpotifyPlayer},
        created() {
            const playerController = new PlayerController(this.$store);
            this.$store.commit('player/setPlayerController', playerController);
            this.initListeners();
        },
        methods: {
            initListeners() {
                this.handleProgress();
            },
            handleProgress() {
                this.$store.watch(
                    $store => $store.player.playerController.progressPercent,
                    progressPercent => {
                        if (progressPercent >= 100) {
                            this.$store.dispatch('player/playNext');
                        }
                    });
            },
        }
    }
</script>

<style scoped>

</style>
