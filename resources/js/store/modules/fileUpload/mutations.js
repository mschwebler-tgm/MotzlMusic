export default {
    setFiles(state, files) {
        state.files = files;
    },
    setUploadInProgress(state, inProgress) {
        state.uploadInProgress = inProgress;
    },
    appendFailedFile(state, file) {
        state.failedFiles.push(file);
    }
}
