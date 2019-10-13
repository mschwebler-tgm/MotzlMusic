import {RenderMobileColumns} from "$scripts/components/TrackTable/Clusterizer/Mobile/columns";
import Clusterizer from "$scripts/components/TrackTable/Clusterizer/Clusterizer";

export default class MobileClusterizer extends Clusterizer {

    _makeTrackRow(rawTrack, trackIndex) {
        const tabIndex = this._getTabIndex();
        const trackId = this._getTrackId(rawTrack);
        return `<div class="track-row mobile" ${tabIndex} ${trackId}>${this._renderColumns(rawTrack, trackIndex)}</div>`;
    }

    _getTabIndex() {
        if (this._options.is('activatable')) {
            return 'tabindex="-1"';
        }
        return '';
    }

    get columnRenderClass() {
        return RenderMobileColumns;
    }
}
