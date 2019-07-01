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
                this.handleActiveClass();
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
            handleActiveClass() {
                this.$store.watch(
                    state => state.player.playerController.playingTrack,
                    (newTrack, oldTrack) => {
                        if (oldTrack) {
                            const trackRows = [...document.getElementsByClassName(`track-row-${oldTrack.id}`)];
                            trackRows.forEach($row => $row.classList.remove('active'));
                        }
                        if (newTrack) {
                            const trackRows = [...document.getElementsByClassName(`track-row-${newTrack.id}`)];
                            trackRows.forEach($row => $row.classList.add('active'));
                        }
                    }
                );
            }
        }
    }
</script>

<style scoped>

</style>
