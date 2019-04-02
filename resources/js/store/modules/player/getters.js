export default {
    controller: state => state.playerController,
    queueController: state => state.queueController,
    playingTrack: state => state.playerController ? state.playerController.playingTrack : null,
    loading: state => state.playerController ? state.playerController.loading : false,
    playing: state => state.playerController ? state.playerController.playing : false,
    progressPercent: state => state.playerController ? state.playerController.progressPercent : 0,
}
