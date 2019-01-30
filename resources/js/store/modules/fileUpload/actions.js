import Uploader from './helpers';

export default {
    init() {
    },
    submit({state, commit}) {
        console.log('submit file upload');
        commit('setTotalFilesCount', state.files.length);
        commit('setRemainingFilesCount', state.files.length);
        commit('toggleInfoBox');
        const uploader = new Uploader(state, commit);
        uploader.uploadFiles(state.files);
    }
}
