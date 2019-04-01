import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const state = {
    playerController: null,
    spotifyPlayer: null,
    playingTrack: null,
    loading: false,
    playing: false,
};

export default {
    state,
    mutations,
    getters,
    actions,
}
