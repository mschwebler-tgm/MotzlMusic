export default {
    files: state => state.files,
    remainingFilesCount: state => state.files.length,
    uploadInProgress: state => state.uploadInProgress,
}