import mutations from './mutations';
import getters from './getters';
import actions from './actions';
/** @type Player */
import playerObject from './helpers/v2/player';

const state = {
    player: playerObject,
};

export default {
    state,
    mutations,
    getters,
    actions,
}
