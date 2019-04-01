export default {
    init() {
    },
    play({ state, commit }, track) {
        commit('setLoading', true);
        state.playerController.play(track)
            .finally(() => commit('setLoading', false))
    },
}
