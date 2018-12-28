export default {
    setMyPlaylists(state, playlists) {
        state.playlists = playlists;
    },
    setMyTracks(state, tracks) {
        state.tracks = tracks;
        state.tracksInitialized = true;
    },
    setMyArtists(state, artists) {
        state.artists = artists;
    },
    setMyAlbums(state, albums) {
        state.albums = albums;
    },
}
