export default {
    init({ commit }) {
        axios.get('/api/my/playlists').then(res => commit('setMyPlaylists', res.data));
        axios.get('/api/my/tracks').then(res => commit('setMyTracks', res.data));
        axios.get('/api/my/recentArtists').then(res => commit('setMyRecentArtists', res.data));
        axios.get('/api/my/albums/byFirstLetter').then(res => commit('setMyAlbums', res.data));
    }
}
