export default {
    files: state => state.files,
    totalFilesCount: state => state.totalFilesCount,
    remainingFilesCount: state => state.remainingFilesCount,
    filesUnableToUpload: state => state.filesUnableToUpload,
    uploadInProgress: state => state.uploadInProgress,
    showInfoBox: state => state.showInfoBox,
}
