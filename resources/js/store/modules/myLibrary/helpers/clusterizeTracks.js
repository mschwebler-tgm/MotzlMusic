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
        const rowContent = this._generateHtmlRowContent(track, index);
        const classes = ['track', `track-row-${track.id}`, 'is-unselectable'];
        if (this._playingTrackId === track.id) {
            classes.push('active');
        }

        return `<div class="${classes.join(' ')}" data-id="${track.id}" tabindex="-1">${rowContent}</div>`;
    }

    _generateHtmlRowContent(track, index) {
        return this._rowNumber(index) +
            this._rowTitle(track) +
            this._rowDuration(track) +
            this._rowArtist(track) +
            this._rowRating(track) +
            this._rowTags(track) +
            this._rowOptions(track);
    }

    _rowNumber(index) {
        return `<div class="track-list-number">&nbsp;<span>${index + 1}.</span></div>`;
    }

    _rowTitle(track) {
        return `<div class="track-list-title">&nbsp;<span title="${track.name}" class="text-truncate">${track.name}</span></div>`;
    }

    _rowDuration(track) {
        return `<div class="track-list-duration">&nbsp;<span>${track.duration_formatted}</span></div>`;
    }

    _rowArtist(track) {
        const artists = track.artists.map(artist => artist.name).join(', ');
        return `<div class="track-list-artist">&nbsp;<span title="${artists}" class="text-truncate">${artists}</span></div>`;
    }

    _rowRating(track) {
        return `<div class="track-list-rating">&nbsp;Star rating</div>`;
    }

    _rowTags(track) {
        return `<div class="flex-1 track-list-options-trigger"></div>` +
            this._getIconsForTrack(track) +
            `<div class="flex-1 track-list-options-trigger"></div>`;
    }

    _getIconsForTrack(track) {
        let icons = '';
        if (track.type === 'spotify') {
            icons += '<div class="track-list-options-trigger"><span class="icon has-text-grey-light" title="From Spotify"><i class="mdi mdi-spotify mdi-24px"></i></span></div>';
        }
        // `<div class="track-list-options-trigger"><span class="icon has-text-grey-light" title="Subscribed from Timi Hendrix"><i class="mdi mdi-account-multiple mdi-24px"></i></span></div>`
        return icons;
    }

    _rowOptions(track) {
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
        return this._rowImage(track) +
            this._rowName(track) +
            this._rowDuration(track) +
            this._rowOptions();
    }

    _rowImage(track) {
        return `<div class="track-list-image pa-1"><img src="${track.album.spotify_image_small}" alt="${track.name}"/></div>`;
    }

    _rowName(track) {
        return `<div class="track-list-name-and-artist pl-2 pr-3"><div class="track-name text-truncate">${track.name}</div><div class="track-artist caption font-weight-thin text-truncate">${track.artists.map(artist => artist.name).join(', ')}</div></div>`;
    }

    _rowDuration(track) {
        return `<div class="track-list-duration">&nbsp;<span class="font-weight-light">${track.duration_formatted}</span></div>`;
    }

    _rowOptions() {
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
export {clusterizeTracksMobile};
