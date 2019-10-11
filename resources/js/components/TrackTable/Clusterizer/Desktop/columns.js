class RenderDesktopColumns {
    static trackTitle(rawTrack, showQueueIndicators) {
        let content = rawTrack.trackData.name;
        if (showQueueIndicators && rawTrack.queueIndex !== undefined) {
            content += ` <span class="track-row-title-queue-indicator">${rawTrack.queueIndex + 1}</span>`
        }
        return `<div class="track-row-title">${content}</div>`;
    }

    static trackAlbum(albumName) {
        return `<div class="track-row-album">${albumName}</div>`;
    }

    static trackArtists(artists) {
        const artistNames = artists.map(artist => artist.name).join(', ');
        return `<div class="track-row-artist">${artistNames}</div>`;
    }

    static trackDuration(durationFormatted) {
        return `<div class="track-row-duration">${durationFormatted}</div>`;
    }
}

const columns = {
    TRACK_TITLE: {
        label: 'Title',
        render: (rawTrack, options) => RenderDesktopColumns.trackTitle(rawTrack, options.is('showQueueIndicators')),
    },
    ALBUM_TITLE: {
        label: 'Album',
        render: rawTrack => RenderDesktopColumns.trackAlbum(rawTrack.trackData.album.name),
    },
    ARTISTS: {
        label: 'Artists',
        render: rawTrack => RenderDesktopColumns.trackArtists(rawTrack.trackData.artists),
    },
    ARTIST: {
        label: 'Artist',
        render: rawTrack => RenderDesktopColumns.trackArtists([rawTrack.trackData.artists[0]]),
    },
    DURATION: {
        label: '',
        render: rawTrack => RenderDesktopColumns.trackDuration(rawTrack.trackData.duration_formatted),
    },
};

export {columns};
