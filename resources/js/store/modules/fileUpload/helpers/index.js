export default class Uploader {
    constructor(state, commit) {
        this._state = state;
        this._commit = commit;
        this._batchSize = 5;
    }

    /**
     * @param files Array<File>
     */
    uploadFiles(files) {
        this._setUploadingState(true);
        const filesToUpload = this._takeNextBatch(files);
        const promises = [];
        filesToUpload.forEach(file => {
            promises.push(this._createSingleFileUpload(file));
        });
        Promise.all(promises).then(_ => {
            this._uploadNextBatch(files);
        }).catch(err => {
            this._uploadNextBatch(files);
        });
    }

    _uploadNextBatch(files) {
        const allFilesAreUploaded = files.length === 0;
        const failedFiles = this._state.failedFiles;

        if (allFilesAreUploaded && failedFiles.length > 0) {
            this._retryFailedFiles(failedFiles);
        } else if (files.length > 0) {
            this.uploadFiles(files);
        } else {
            this._setUploadingState(false);
        }
    }

    _retryFailedFiles(failedFiles) {
        failedFiles.forEach(file => this._createSingleFileUpload(file, false));
    }

    _setUploadingState(uploading) {
        this._commit('setUploadInProgress', uploading);
        window.onbeforeunload = _ => uploading || null;
    }

    _takeNextBatch(files) {
        return files.splice(0, this._batchSize);
    }

    _createSingleFileUpload(file, firstTry = true) {
        return new Promise((resolve, reject) => {
            axios.post('/api/uploadTrack', Uploader._createFormDataForFile(file), {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).catch(_ => {
                if (firstTry) {
                    this._commit('appendFailedFile', file);
                }
                reject();
            }).then(resolve);
        });
    }

    static _createFormDataForFile(file) {
        let formData = new FormData();
        formData.append(file.name, file);
        return formData;
    }
}
