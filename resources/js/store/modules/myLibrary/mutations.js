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
    setMyAlbums(state, albums) {
        state.albums = albums;
    },
}
