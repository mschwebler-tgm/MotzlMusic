import {RenderDesktopColumns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";
import Clusterizer from "$scripts/components/TrackTable/Clusterizer/Clusterizer";

export default class DesktopClusterizer extends Clusterizer {

    _makeTrackRow(rawTrack, trackIndex) {
        const tabIndex = this._getTabIndex();
        const trackId = this._getTrackId(rawTrack);
        const queuedStatus = this._getQueuedStatus(rawTrack);
        const trackRow = `<div class="track-row ${queuedStatus}" ${tabIndex} ${trackId}>${this._renderColumns(rawTrack, trackIndex)}</div>`;

        if (this._options.is('draggable')) {
            return `<div class="smooth-dnd-draggable-wrapper">${trackRow}</div>`;
        }
        return trackRow;
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
