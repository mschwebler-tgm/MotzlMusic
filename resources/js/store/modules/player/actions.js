export default {
    init() {
    },
    play({state, commit}, track) {
        state.playerController.play(track);
    },
    pause({state, commit}) {
        state.playerController.pause();
    }
}
