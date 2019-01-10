export default {
    setMyPlaylists(state, playlists) {
        state.playlists = playlists;
        state.playlistsInitialized = true;
    },
    setMyTracks(state, tracks) {
        state.tracks = tracks;
        state.tracksInitialized = true;
    },
    setMyTopArtists(state, artists) {
        state.topArtists = artists;
        state.topArtistsInitialized = true;
    },
    setMyRecentArtists(state, artists) {
        state.recentArtists = artists;
        state.recentArtistsInitialized = true;
    },
    setMyAlbums(state, albums) {
        state.albums = albums;
        state.albumsInitialized = true;
    },
}
