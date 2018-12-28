export default {
    setMyPlaylists(state, playlists) {
        state.playlists = playlists;
        state.playlistsInitialized = true;
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
