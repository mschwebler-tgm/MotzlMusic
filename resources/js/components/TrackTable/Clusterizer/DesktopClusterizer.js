import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";

export default class DesktopClusterizer {

    constructor() {
        this._dragContainerId = 'abc';
        this._options = new ClusterizeOptions();
    }

    configure(options) {
        this._options.setOptions(options);
    }

    generateForTracks(rawTracks) {
        const trackRows = rawTracks.map(rawTrack => this._makeTrackRow(rawTrack));
        const rowsHtml = trackRows.join('');
        if (this._options.is('draggable')) {
            return `<div id="${this._dragContainerId}">${rowsHtml}</div>`;
        }
        return rowsHtml;
    }

    _makeTrackRow(track) {
        return `<div class="track-row">${this._renderColumns(track)}</div>`;
    }

    _renderColumns(rawTrack) {
        return this._options.getColumns().map(column => column.render(rawTrack)).join('');
    }
}
