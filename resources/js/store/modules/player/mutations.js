import app from '../../../app'

export default {
    setPlayerController(state, playerController) {
        state.playerController = playerController;
    },
    setSpotifyPlayer(state, player) {
        state.playerController.spotifyPlayer.player = player;
    },
    setPlayingTrack(state, track) {
        state.playerController.playingTrack = track;
    },
    setLoading(state, isLoading) {
        state.playerController.loading = isLoading;
    },
    setPlayingState(state, isPlaying) {
        state.playerController.playing = isPlaying;
    },
    setQueue(state, tracks) {
        state.queueController.setQueue(tracks);
    },
    setQueueTrack(state, track) {
        state.queueController.setActiveTrack(track);
    },
    addTrackToQueue(state, track) {
        state.queueController.addTrackToQueue(track);
        app.showAlert('1 track added to queue');
    },
}
