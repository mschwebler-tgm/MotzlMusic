const validateArray = function (toCheck) {
    return Array.isArray(toCheck) ? toCheck : [];
};

export default {
    setMyPlaylists(state, playlists) {
        state.playlists = playlists;
        state.playlistsInitialized = true;
    },
    setMyTracks(state, tracks) {
        state.tracks = validateArray(tracks);
        state.tracksInitialized = true;
    },
    setMyArtists(state, artists) {
        state.artists = validateArray(artists);
        state.artistsInitialized = true;
    },
    setMyAlbums(state, albums) {
        state.albums = validateArray(albums);
        state.albumsInitialized = true;
    },
}
