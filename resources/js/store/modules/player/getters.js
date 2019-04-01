export default {
    controller: state => state.playerController,
    playingTrack: state => state.playerController ? state.playerController.playingTrack : null,
    loading: state => state.loading,
    playing: state => state.playing,
}