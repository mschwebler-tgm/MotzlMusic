export default class Uploader {
    constructor(commit) {
        this._commit = commit;
        this._batchSize = 5;
    }

    /**
     * @param files Array<File>
     */
    uploadFiles(files) {
        Uploader._preventSiteLeave(true);
        const filesToUpload = this._takeNextBatch(files);
        const promises = [];
        filesToUpload.forEach(file => {
            console.log('Uploading ' + file.name);
            promises.push(Uploader._createSingleFileUpload(file));
        });
        console.log('waiting for uploads to complete...');
        Promise.all(promises).then(_ => {
            console.log('complete. remaining files: ' + files.length);
            if (files.length > 0) {
                this.uploadFiles(files);
            } else {
                Uploader._preventSiteLeave(false);
            }
        }).catch(err => console.log('fail', err));
    }

    static _preventSiteLeave(prevent) {
        window.onbeforeunload = _ => prevent || null;
    }

    _takeNextBatch(files) {
        return files.splice(0, this._batchSize);
    }

    static _createSingleFileUpload(file) {
        return axios.post('/api/uploadTrack', Uploader._createFormDataForFile(file), {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
    }

    static _createFormDataForFile(file) {
        let formData = new FormData();
        formData.append(file.name, file);
        return formData;
    }
}
