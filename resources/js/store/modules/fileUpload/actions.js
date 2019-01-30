import Uploader from './helpers';

export default {
    init() {
    },
    submit({state, commit}) {
        commit('setTotalFilesCount', state.files.length);
        commit('setRemainingFilesCount', state.files.length);
        commit('setShowInfoBox', true);
        const uploader = new Uploader(state, commit);
        uploader.uploadFiles(state.files);
    }
}
