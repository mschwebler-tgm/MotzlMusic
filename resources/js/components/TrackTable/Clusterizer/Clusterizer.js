export default class Clusterizer {
    /**
     * @param options ClusterizeOptions
     */
    constructor(options) {
        this._options = options;
    }

    configure(options) {
        this._options.setOptions(options);
    }

    generateForTracks(rawTracks) {
        return rawTracks.map((rawTrack, trackIndex) => this._makeTrackRow(rawTrack, trackIndex));
    }

    _makeTrackRow() {
        throw new Error('not implemented');
    }

    _getTabIndex() {
        if (this._options.is('activatable')) {
            return 'tabindex="-1"';
        }
        return '';
    }

    _renderColumns(rawTrack, trackIndex) {
        return this._options.getColumns().map(column => column.render(rawTrack, this._options, trackIndex)).join('');
    }

    _getTrackId(rawTrack) {
        const id = this.columnRenderClass['getTrackData'](rawTrack).id;
        return `data-id="${id}"`;
    }

    _getQueuedStatus(rawTrack) {
        return rawTrack.isQueued === true ? 'queued' : '';
    }

    get columnRenderClass() {
        throw new Error('not implemented');
    }
}
