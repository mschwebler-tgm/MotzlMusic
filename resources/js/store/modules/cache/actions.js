export default {
    init() {
    },
    fetchSelectedPlaylist({commit}, id) {
        axios.get(`/api/playlist/${id}`).then(res => commit('setSelectedPlaylist', res.data));
    }
}
