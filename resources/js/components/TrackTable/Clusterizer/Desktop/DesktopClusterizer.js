import {RenderDesktopColumns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";

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

    _makeTrackRow(rawTrack, trackIndex) {
        const tabIndex = this._getTabIndex();
        const trackId = this._getTrackId(rawTrack);
        return `<div class="track-row" ${tabIndex} ${trackId}>${this._renderColumns(rawTrack, trackIndex)}</div>`;
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
        const id = RenderDesktopColumns.getTrackData(rawTrack).id;
        return `data-id="${id}"`;
    }
}
