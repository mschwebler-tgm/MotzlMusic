import mutations from './mutations';
import getters from './getters';
import actions from './actions';

const state = {
    audioFeaturesUrl: null,
    isInEditMode: false,
    subContent: [],
    subContentEditClone: [],
    subContentIsSaving: false,
    availableSubContent: [],
};

export default {
    state,
    mutations,
    getters,
    actions,
}
