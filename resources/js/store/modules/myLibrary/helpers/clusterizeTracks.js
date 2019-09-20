// TODO refactor this:
// Mobile and desktop should have same end-elements (e.g. .track-list-title). Surrounding elements can differ.
// This is important for store-watchers, which re-render parts of the table for queue-indicators, star-ratings etc.

import StarRating from "../../../../components/_BaseComponents/StarRating";

class Clusterizer {

    constructor(tracks, playingTrackId) {
        this._tracks = tracks;
        this._playingTrackId = playingTrackId;
    }

    toHtml() {
        return this._tracks.map((track, index) => {
            return this._generateHtmlRowFor(track, index);
        });
    }

    _generateHtmlRowFor(track, index) {
        const rowContent = Clusterizer._generateHtmlRowContent(track, index);
        const classes = ['track', `track-row-${track.id}`, 'is-unselectable'];
        if (this._playingTrackId === track.id) {
            classes.push('active');
        }

        return `<div class="${classes.join(' ')}" data-id="${track.id}" tabindex="-1">${rowContent}</div>`;
    }

    static _generateHtmlRowContent(track, index) {
        return Clusterizer._rowNumber(index) +
            Clusterizer._rowTitle(track.name) +
            Clusterizer._rowDuration(track) +
            Clusterizer._rowArtist(track) +
            Clusterizer._rowRating(track) +
            Clusterizer._rowTags(track) +
            Clusterizer._rowOptions(track);
    }

    static _rowNumber(index) {
        return `<div class="track-list-number">&nbsp;<span>${index + 1}.</span></div>`;
    }

    static _rowTitle(title, extraInfo) {
        return `<div class="track-list-title">&nbsp;<span title="${title}" class="text-truncate">${title} ${extraInfo || ''}</span></div>`;
    }

    static _rowDuration(track) {
        return `<div class="track-list-duration">&nbsp;<span>${track.duration_formatted}</span></div>`;
    }

    static _rowArtist(track) {
        const artists = track.artists.map(artist => artist.name).join(', ');
        return `<div class="track-list-artist">&nbsp;<span title="${artists}" class="text-truncate">${artists}</span></div>`;
    }

    static _rowRating(track) {
        const stars = StarRating.getStarSVGs(track.rating);
        return `<div class="track-list-rating">${stars.join('')}</div>`;
    }

    static _rowTags(track) {
        return `<div class="flex-1 track-list-options-trigger"></div>` +
            Clusterizer._getIconsForTrack(track) +
            `<div class="flex-1 track-list-options-trigger"></div>`;
    }

    static _getIconsForTrack(track) {
        let icons = '';
        if (track.provider === 'spotify') {
            icons += '<div class="track-list-options-trigger"><span class="icon has-text-grey-light" title="From Spotify"><i class="mdi mdi-spotify mdi-24px"></i></span></div>';
        }
        // `<div class="track-list-options-trigger"><span class="icon has-text-grey-light" title="Subscribed from Timi Hendrix"><i class="mdi mdi-account-multiple mdi-24px"></i></span></div>`
        return icons;
    }

    static _rowOptions(track) {
        return `<div class="track-list-more-options track-options"><span class="icon has-text-grey-light pointer track-options" title="More options"><i class="mdi mdi-dots-vertical mdi-24px track-options"></i></span></div>`;
    }
}

class MobileClusterizer {
    constructor(tracks, playingTrackId) {
        this._tracks = tracks;
        this._playingTrackId = playingTrackId;
    }

    toHtml() {
        return this._tracks.map(track => this._generateHtmlRowFor(track));
    }

    _generateHtmlRowFor(track) {
        const rowContent = this._generateHtmlRowContent(track);
        const classes = ['track', `track-row-${track.id}`, 'is-unselectable'];
        if (this._playingTrackId === track.id) {
            classes.push('active');
        }

        return `<div class="${classes.join(' ')}" data-id="${track.id}" tabindex="-1">${rowContent}</div>`;
    }

    _generateHtmlRowContent(track) {
        return MobileClusterizer._rowImage(track) +
            MobileClusterizer._rowName(track) +
            MobileClusterizer._rowDuration(track) +
            MobileClusterizer._rowOptions();
    }

    static _rowImage(track) {
        return `<div class="track-list-image pa-1"><img src="${track.album.spotify_image_small}" alt="${track.name}"/></div>`;
    }

    static _rowName(track) {
        return `<div class="track-list-name-and-artist pl-2 pr-3"><div class="track-list-title">${MobileClusterizer._rowTitle(track.name)}</div><div class="track-artist caption font-weight-thin text-truncate">${track.artists.map(artist => artist.name).join(', ')}</div></div>`;
    }

    static _rowTitle(title, extraInfo) {
        return `<div class="track-name text-truncate">${title} ${extraInfo || ''}</div>`;
    }

    static _rowDuration(track) {
        return `<div class="track-list-duration">&nbsp;<span class="font-weight-light">${track.duration_formatted}</span></div>`;
    }

    static _rowRating(track) {
        // do nothing
    }

    static _rowOptions() {
        return `<div class="track-list-mobile-options"><span class="icon has-text-grey-light pointer track-options" title="More options"><i class="mdi mdi-dots-vertical mdi-24px track-options"></i></span></div>`;
    }
}

function clusterizeTracks(tracks, playingTrackId) {
    const clusterizer = new Clusterizer(tracks, playingTrackId);

    return clusterizer.toHtml();
}

function clusterizeTracksMobile(tracks, playingTrackId) {
    const clusterizer = new MobileClusterizer(tracks, playingTrackId);

    return clusterizer.toHtml();
}

export default clusterizeTracks;
export {clusterizeTracksMobile, Clusterizer, MobileClusterizer};
