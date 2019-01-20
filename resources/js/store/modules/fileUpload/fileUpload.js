import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const state = {
    files: [],
    uploadInProgress: false,
    failedFiles: [],
};

export default {
    state,
    mutations,
    getters,
    actions,
}
