import Uploader from './helpers';

export default {
    init() {
    },
    submit({state, commit}) {
        console.log('submit file upload');
        const uploader = new Uploader(state, commit);
        uploader.uploadFiles(state.files);
    }
}
