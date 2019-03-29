export default {
    setPlayerController(state, playerController) {
        state.playerController = playerController;
    },
    setSpotifyPlayer(state, player) {
        state.spotifyPlayer = player;
    },
    setPlayingTrack(state, track) {
        state.playingTrack = track;
    }
}
