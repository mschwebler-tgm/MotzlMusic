import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const state = {
    files: [],
    totalFilesCount: 0,
    remainingFilesCount: 0,
    uploadInProgress: false,
    failedFiles: [],
    showInfoBox: false,
};

export default {
    state,
    mutations,
    getters,
    actions,
}
