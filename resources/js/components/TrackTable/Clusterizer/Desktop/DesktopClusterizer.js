export default class DesktopClusterizer {

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
        return rawTracks.map(rawTrack => this._makeTrackRow(rawTrack));
    }

    _makeTrackRow(track) {
        return `<div class="track-row">${this._renderColumns(track)}</div>`;
    }

    _renderColumns(rawTrack) {
        return this._options.getColumns().map(column => column.render(rawTrack)).join('');
    }
}
