export default {
    init() {
    },
    play({state}, track) {
        state.playerController.play(track);
    },
    pause({state}) {
        state.playerController.pause();
    },
    playNext({state, dispatch}) {
        state.queueController.setNext();
        dispatch('play', state.queueController.currentTrack);
    },
    playPrevious({state, dispatch}) {
        state.queueController.setPrevious();
        dispatch('play', state.queueController.currentTrack);
    },
}
