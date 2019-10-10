import {defaultOptions, availableOptions} from "$scripts/components/TrackTable/Clusterizer/defaultOptions";

export default class DesktopClusterizer {

    constructor() {
        this._dragContainerId = 'abc';
        this._options = defaultOptions;
    }

    configure(options) {
        Object.keys(options).forEach(optionKey => {
            this._validateOptionKey(optionKey);
            this._options[optionKey] = options[optionKey];
        });
    }

    _validateOptionKey(optionKey) {
        if (!availableOptions.includes(optionKey)) {
            throw new Error(`[Clusterizer] Provided option '${optionKey}' is not valid. Available options: ${availableOptions.join(', ')}`);
        }
    }

    generateForTracks(tracks) {
        const trackRows = tracks.map(() => '<div class="track-row"></div>');
        const rowsHtml = trackRows.join('');
        if (this._options.draggable) {
            return `<div id="${this._dragContainerId}">${rowsHtml}</div>`;
        }
        return rowsHtml;
    }
}
