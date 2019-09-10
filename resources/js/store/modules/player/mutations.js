import app from '../../../app'
import player from "./helpers/v2/player";

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
        const wasQueued = player.queueTrack(track);
        if (wasQueued) {
            app.showAlert('1 track added to queue');
        }
    },
}
