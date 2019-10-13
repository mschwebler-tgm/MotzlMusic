import {RenderDesktopColumns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";
import Clusterizer from "$scripts/components/TrackTable/Clusterizer/Clusterizer";

export default class DesktopClusterizer extends Clusterizer {

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

    get columnRenderClass() {
        return RenderDesktopColumns;
    }
}
