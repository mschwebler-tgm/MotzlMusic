export default class Uploader {
    constructor(commit) {
        this._commit = commit;
        this._batchSize = 5;
    }

    /**
     * @param files Array<File>
     */
    uploadFiles(files) {
        const filesToUpload = files.splice(0, this._batchSize);
        const promises = [];
        filesToUpload.forEach(file => {
            console.log('Uploading ' + file.name);
            promises.push(axios.post('/api/uploadTrack', file));
        });
        console.log('waiting for uploads to complete...');
        Promise.all(promises).then(_ => {
            console.log('complete. remaining files: ' + files.length);
            if (files.length > 0) {
                this.uploadFiles(files);
            }
        }).catch(err => console.log('fail', err));
    }
}
