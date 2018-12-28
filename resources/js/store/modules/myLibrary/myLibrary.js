import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const state = {
    playlists: [],
    tracks: [],
    tracksInitialized: false,
    artists: [],
    albums: [],
};

export default {
    state,
    mutations,
    getters,
    actions,
}
