import mutations from './mutations';
import getters from './getters';
import actions from './actions';
import QueueController from './helpers/QueueController';

const state = {
    playerController: null,
    spotifyPlayer: null,
    queueController: new QueueController(),
    activePlaylistId: null,
};

export default {
    state,
    mutations,
    getters,
    actions,
}
