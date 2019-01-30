/**
 * This class uploads lots of files starting with a chunk of n files.
 * After a single upload completes another file is uploaded immediately.
 *
 * Failed uploads are queued for another try and added to a list of failed files
 * if still not successful.
 */
export default class Uploader {
    constructor(state, commit) {
        this._state = state;
        this._commit = commit;
        this._batchSize = 5;
        this._files = [];
        this._retryingFailed = false;
    }

    /**
     * @param files Array<File>
     */
    uploadFiles(files) {
        this._files = files;
        this._setUploadingState(true);
        this.startUpload(this._batchSize);
    }

    startUpload(amount) {
        const filesToUpload = this._files.splice(0, amount);
        if (filesToUpload.length === 0 && !this._retryingFailed) {
            this._retryingFailed = true;
            this._retryFailedFiles(this._state.failedFiles);
            return;
        }

        filesToUpload.forEach(file => this._createSingleFileUpload(file));
    }

    _retryFailedFiles(files) {
        const file = files.shift();
        if (!file) {
            this._setUploadingState(false);
            return;
        }

        axios.post('/api/uploadTrack', Uploader._createFormDataForFile(file), {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(_ => {
            this._commit('decrementRemainingFilesCount');
            this._retryFailedFiles(files);
        }).catch(_ => {
            this._commit('appendCorruptFile', file);
            this._retryFailedFiles(files);
        });
    }

    _createSingleFileUpload(file) {
        axios.post('/api/uploadTrack', Uploader._createFormDataForFile(file), {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(_ => {
            this._commit('decrementRemainingFilesCount');
            this.startUpload(1);
        }).catch(_ => {
            this._commit('appendFailedFile', file);
            this.startUpload(1);
        });
    }

    _setUploadingState(uploading) {
        this._commit('setUploadInProgress', uploading);
        window.onbeforeunload = _ => uploading || null;
    }

    static _createFormDataForFile(file) {
        let formData = new FormData();
        formData.append(file.name, file);
        return formData;
    }
}
