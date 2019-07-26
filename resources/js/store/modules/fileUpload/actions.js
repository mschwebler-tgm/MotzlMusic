import Uploader from './helpers';
import VueRoot from '../../../app';
import StatusInfos from '../../../components/Layout/StatusInfo/StatusInfos'

export default {
    init() {
    },
    submit({state, commit}) {
        commit('setTotalFilesCount', state.files.length);
        commit('setRemainingFilesCount', state.files.length);
        commit('setShowInfoBox', true);
        const uploader = new Uploader(state, commit);
        uploader.uploadFiles(state.files);
        VueRoot.statusInfo.component = StatusInfos.UPLOAD_INFO;
        VueRoot.statusInfo.show = true;
    }
}
