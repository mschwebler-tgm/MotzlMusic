import cacheRequest from "$scripts/cacheReqest/cacheRequest";

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
        cacheRequest.cacheTracks(...tracks);
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
    removeTrack(state, trackId) {
        const removeTrack = track => track.id !== trackId;
        state.tracks = state.tracks.filter(removeTrack);
        state.artists.forEach(item => item.tracks && (item.tracks = item.tracks.filter(removeTrack)));
        state.albums.forEach(item => item.tracks && (item.tracks = item.tracks.filter(removeTrack)));
        Object.values(state.playlists).forEach(item => item.tracks && (item.tracks = item.tracks.filter(removeTrack)));
    },
}
