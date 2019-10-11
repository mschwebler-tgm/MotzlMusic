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
        return rawTracks.map((rawTrack, trackIndex) => this._makeTrackRow(rawTrack, trackIndex));
    }

    _makeTrackRow(track, trackIndex) {
        return `<div class="track-row">${this._renderColumns(track, trackIndex)}</div>`;
    }

    _renderColumns(rawTrack, trackIndex) {
        return this._options.getColumns().map(column => column.render(rawTrack, this._options, trackIndex)).join('');
    }
}
