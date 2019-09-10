import mutations from './mutations';
import getters from './getters';
import actions from './actions';
import QueueController from './helpers/QueueController';
/** @type Player */
import playerObj from './helpers/v2/player';

const state = {
    player: playerObj,
    playerController: null,
    spotifyPlayer: null,
    queueController: new QueueController(),
    activeItem: {},
};

export default {
    state,
    mutations,
    getters,
    actions,
}
