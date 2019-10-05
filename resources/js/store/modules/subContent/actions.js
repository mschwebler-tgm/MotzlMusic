import app from '$scripts/app';

export default {
    init() {
    },
    saveEdit({state, commit}) {
        console.log('save sub content');
        state.subContentIsSaving = true;
        axios.put('/api/my/subContent', {subContent: state.subContentEditClone})
            .then(() => {
                state.subContent = [...state.subContentEditClone];
                state.isInEditMode = false;
            })
            .catch(err => {
                console.error(err);
                app.showAlert('Failed to save sub content', 'error');
            })
            .finally(() => state.subContentIsSaving = false);
    }
}
