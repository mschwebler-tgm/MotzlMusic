export default {
    setFocusedItems(state, items) {
        state.focusedItems = items;
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
