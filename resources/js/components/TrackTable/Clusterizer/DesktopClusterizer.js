import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";

export default class DesktopClusterizer {

    constructor() {
        this._dragContainerId = 'abc';
        this._options = new ClusterizeOptions();
    }

    configure(options) {
        this._options.setOptions(options);
    }

    generateForTracks(tracks) {
        const trackRows = tracks.map(() => '<div class="track-row"></div>');
        const rowsHtml = trackRows.join('');
        if (this._options.is('draggable')) {
            return `<div id="${this._dragContainerId}">${rowsHtml}</div>`;
        }
        return rowsHtml;
    }
}
