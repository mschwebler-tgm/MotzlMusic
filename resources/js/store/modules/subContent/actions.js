import app from '$scripts/app';

export default {
    init({state}) {
        axios.get('/api/my/subContent/available')
            .then(res => state.availableSubContent = res.data);
    },
    saveEdit({state}) {
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
