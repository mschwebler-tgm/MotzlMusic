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
    artists: [],
    artistsInitialized: false,
    albums: [],
    albumsSingleTracks: [],
    albumsInitialized: false,
};

export default {
    state,
    mutations,
    getters,
    actions,
}
