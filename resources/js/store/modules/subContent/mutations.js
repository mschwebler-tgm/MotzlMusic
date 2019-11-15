export default {
    setAudioFeatures(state, url) {
        state.audioFeaturesUrl = url;
    },
    activateEditMode(state) {
        state.subContentEditClone = [...state.subContent];
        state.isInEditMode = true;
    },
    setSubContent(state, subContent) {
        state.subContent = subContent;
    },
    cancelEditMode(state) {
        state.subContentEditClone = [...state.subContent];
        state.isInEditMode = false;
    }
}
