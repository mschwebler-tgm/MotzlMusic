export default {
    setFiles(state, files) {
        state.files = files;
    },
    setUploadInProgress(state, inProgress) {
        state.uploadInProgress = inProgress;
    },
    appendFailedFile(state, file) {
        state.failedFiles.push(file);
    },
    setTotalFilesCount(state, count) {
        state.totalFilesCount = count;
    },
    setRemainingFilesCount(state, count) {
        state.remainingFilesCount = count;
    },
    decrementRemainingFilesCount(state) {
        state.remainingFilesCount--;
    },
    toggleInfoBox(state) {
        state.showInfoBox = !state.showInfoBox;
    },
}
