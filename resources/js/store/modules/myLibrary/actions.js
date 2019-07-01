import app from '../../../app';

export default {
    init({commit}) {
        axios.get('/api/my/playlists').then(res => commit('setMyPlaylists', res.data));
        axios.get('/api/my/tracks').then(res => commit('setMyTracks', res.data));
        axios.get('/api/my/artists/byFirstLetter').then(res => commit('setMyArtists', res.data));
        axios.get('/api/my/albums/byFirstLetter').then(res => commit('setMyAlbums', res.data));
    },
    removeTrack({state, commit, dispatch}, trackId) {
        return axios.delete(`/api/my/tracks/${trackId}`)
            .then(() => commit('removeTrack', trackId))
            .then(() => app.showAlert('Track removed from Library', 'undo', () => dispatch('restoreTrack', trackId)))
            .catch(() => app.showAlert('Failed to remove track from Library', null, null, 'error'));
    },
    restoreTrack({dispatch, commit}, trackId) {
        return axios.put(`/api/my/tracks/${trackId}`)
            .then(() => axios.get('/api/my/tracks').then(res => commit('setMyTracks', res.data)))
            .then(() => app.showAlert('Track successfully restored'));
    }
}
