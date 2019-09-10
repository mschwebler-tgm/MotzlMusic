export default {
    init() {
    },
    addSelectedToQueue({rootState, commit}) {
        const focusedItems = rootState.subContent.focusedItems;
        const focusedTracks = focusedItems.filter(item => item.type === 'track');  // only allow tracks to be queued for now
        focusedTracks.forEach(track => commit('addTrackToQueue', track));
    },
}
