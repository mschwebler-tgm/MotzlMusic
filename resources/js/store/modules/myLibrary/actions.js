export default {
    init({ commit }) {
        axios.get('/api/my/playlists').then(res => commit('setMyPlaylists', res.data));
        axios.get('/api/my/tracks').then(res => commit('setMyTracks', res.data));
        axios.get('/api/my/artists').then(res => commit('setMyArtists', res.data));
        axios.get('/api/my/albums').then(res => commit('setMyAlbums', res.data));
    }
}
