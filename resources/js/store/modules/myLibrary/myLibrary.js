import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const state = {
    playlists: [],
    playlistsInitialized: false,
    tracks: [],
    tracksInitialized: false,
    topArtists: [],
    topArtistsInitialized: false,
    albums: [],
};

export default {
    state,
    mutations,
    getters,
    actions,
}
