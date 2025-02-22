import app from '$scripts/app';
import StatusInfos from "$components/components/Layout/StatusInfo/StatusInfos";

export default {
    init({commit}) {
        const requests = [];
        requests.push(axios.get('/api/my/tracks')
            .then(res => commit('setMyTracks', res.data))
            .then(() => {
                axios.get('/api/my/artists/singleTracks').then(res => commit('setMyArtistsSingleTracks', res.data));
                axios.get('/api/my/albums/singleTracks').then(res => commit('setMyAlbumsSingleTracks', res.data));
            }));
        requests.push(axios.get('/api/my/playlists').then(res => commit('setMyPlaylists', res.data)));
        requests.push(axios.get('/api/my/artists/byFirstLetter').then(res => commit('setMyArtists', res.data)));
        requests.push(axios.get('/api/my/albums/byFirstLetter').then(res => commit('setMyAlbums', res.data)));

        return Promise.all(requests);
    },
    removeTrack({state, commit, dispatch}, trackId) {
        app.statusInfo.component = StatusInfos.GENERIC;
        app.statusInfo.data.text = 'Removing track';
        app.statusInfo.show = true;
        return axios.delete(`/api/my/tracks/${trackId}`)
            .then(() => commit('removeTrack', trackId))
            .then(() => app.statusInfo.show = false)
            .then(() => app.showAlert('Track removed from Library', 'info', 'undo', () => {
                app.snackbar.show = false;
                dispatch('restoreTrack', trackId)
            }))
            .catch(() => app.showAlert('Failed to remove track from Library', 'error'));
    },
    restoreTrack({dispatch, commit}, trackId) {
        app.statusInfo.component = StatusInfos.GENERIC;
        app.statusInfo.data.text = 'Restoring track';
        app.statusInfo.show = true;
        return axios.put(`/api/my/tracks/${trackId}`)
            .then(() => axios.get('/api/my/tracks').then(res => commit('setMyTracks', res.data)))
            .then(() => app.statusInfo.show = false)
            .then(() => app.showAlert('Track successfully restored'));
    }
}
