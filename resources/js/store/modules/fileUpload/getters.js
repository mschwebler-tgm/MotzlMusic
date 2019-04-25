export default {
    files: state => state.files,
    totalFilesCount: state => state.totalFilesCount,
    remainingFilesCount: state => state.remainingFilesCount,
    filesUnableToUpload: state => state.filesUnableToUpload,
    uploadInProgress: state => state.uploadInProgress,
    showInfoBox: state => state.showInfoBox,
    progressInPercent: state => state.totalFilesCount > 0 ? ((state.totalFilesCount - state.remainingFilesCount) / state.totalFilesCount) * 100 : 0,
}
