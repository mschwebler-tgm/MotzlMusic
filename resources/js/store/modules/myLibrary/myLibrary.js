import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const state = {
    playlists: {
        recent: [],
        spotify: [],
        other: [],
    },
    playlistsInitialized: false,
    tracks: [],
    tracksInitialized: false,
    topArtists: [],
    topArtistsInitialized: false,
    recentArtists: [],
    recentArtistsInitialized: false,
    albums: [],
    albumsInitialized: false,
};

export default {
    state,
    mutations,
    getters,
    actions,
}
