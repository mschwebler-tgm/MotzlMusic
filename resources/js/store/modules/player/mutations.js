export default {
    setPlayerController(state, playerController) {
        state.playerController = playerController;
    },
    setSpotifyPlayer(state, player) {
        state.playerController.spotifyPlayer.player = player;
    },
    setPlayingTrack(state, track) {
        state.playingTrack = track;
    },
    setLoading(state, isLoading) {
        state.loading = isLoading;
    }
}
