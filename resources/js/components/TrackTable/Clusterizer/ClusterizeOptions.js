import {availableOptions, defaultOptions} from "$scripts/components/TrackTable/Clusterizer/defaultOptions";

export default class ClusterizeOptions {

    constructor() {
        this._options = {...defaultOptions};
    }

    setOptions(options) {
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

    is(optionKey) {
        return this.get(optionKey) === true;
    }

    get(optionKey) {
        return this._options[optionKey];
    }

    getColumns() {
        if (this.is('desktop')) {
            return this._options.desktopColumns;
        }
        return this._options.mobileColumns;
    }
}
