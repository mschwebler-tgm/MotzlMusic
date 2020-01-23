import StarRating from "$scripts/components/_BaseComponents/StarRating";
import Track from "$store/player/helpers/v2/Track";

class RenderDesktopColumns {
    static getTrackData(rawTrack) {
        if (rawTrack instanceof Track) {
            return rawTrack.trackData;
        }
        return rawTrack;
    }

    static trackIndex(index) {
        return `<div class="track-row-number">${index + 1}</div>`;
    }

    static trackTitle(rawTrack, options) {
        let content = RenderDesktopColumns.getTrackData(rawTrack).name;
        if (rawTrack instanceof Track && options.is('showQueueIndicators') && rawTrack.isQueued) {
            content += ` <div class="track-row-title-queue-indicator">${rawTrack.queueIndex + 1}</div>`
        }
        return `<div class="track-row-title text-truncate">${content}</div>`;
    }

    static trackAlbum(album) {
        return `<div class="track-row-album to-album text-truncate" data-id="${album.id}">${album.name}</div>`;
    }

    static albumImage(imageSrc) {
        return `<div class="track-row-image"><img src="${imageSrc}" alt=""></div>`;
    }

    static trackArtists(artists) {
        const artistNames = artists.map(artist => `<span data-id="${artist.id}" class="to-artist">${artist.name}</span>`).join(', ');
        return `<div class="track-row-artist text-truncate">${artistNames}</div>`;
    }

    static trackDuration(durationFormatted) {
        return `<div class="track-row-duration">${durationFormatted}</div>`;
    }

    static trackRating(rating) {
        const stars = StarRating.getStarSVGs(rating);
        return `<div class="track-row-rating">${stars.join('')}</div>`;
    }

    static infoIcons(track) {
        let icons = '';
        if (track.provider === 'spotify') {
            icons += '<div><span class="icon has-text-grey-light" title="From Spotify"><i class="mdi mdi-spotify mdi-24px"></i></span></div>';
        }
        // `<div class="track-list-options-trigger"><span class="icon has-text-grey-light" title="Subscribed from Timi Hendrix"><i class="mdi mdi-account-multiple mdi-24px"></i></span></div>`

        return `<div class="track-row-info-icons">${icons}</div>`;
    }

    static trackOptions() {
        return `<div class="track-row-options"><span class="icon has-text-grey-light pointer" title="More options"><i class="mdi mdi-dots-vertical mdi-24px track-options"></i></span></div>`;
    }
}

const columns = {
    INDEX: {
        header: {
            classes: 'track-row-header track-row-number__header',
            label: '#',
        },
        render: (rawTrack, options, index) => RenderDesktopColumns.trackIndex(index),
    },
    TRACK_TITLE: {
        header: {
            classes: 'track-row-header track-row-title__header',
            label: 'Title',
        },
        sortIdentifier: 'name',
        render: (rawTrack, options) => RenderDesktopColumns.trackTitle(rawTrack, options),
    },
    ALBUM_TITLE: {
        header: {
            classes: 'track-row-header track-row-album__header',
            label: 'Album',
        },
        sortIdentifier: 'album',
        render: rawTrack => RenderDesktopColumns.trackAlbum(RenderDesktopColumns.getTrackData(rawTrack).album),
    },
    ALBUM_IMAGE: {
        header: {
            classes: 'track-row-header track-row-image__header',
            label: '',
        },
        render: rawTrack => RenderDesktopColumns.albumImage(RenderDesktopColumns.getTrackData(rawTrack).album.image),
    },
    ARTISTS: {
        header: {
            classes: 'track-row-header track-row-artist__header',
            label: 'Artists',
        },
        sortIdentifier: 'artist',
        render: rawTrack => RenderDesktopColumns.trackArtists(RenderDesktopColumns.getTrackData(rawTrack).artists),
    },
    ARTIST: {
        header: {
            classes: 'track-row-header track-row-artist__header',
            label: 'Artist',
        },
        sortIdentifier: 'artist',
        render: rawTrack => RenderDesktopColumns.trackArtists([RenderDesktopColumns.getTrackData(rawTrack).artists[0]]),
    },
    DURATION: {
        header: {
            classes: 'track-row-header track-row-duration__header',
            label: '#',
            icon: 'mdi-circle-slice-3',
        },
        sortIdentifier: 'duration',
        render: rawTrack => RenderDesktopColumns.trackDuration(RenderDesktopColumns.getTrackData(rawTrack).duration_formatted),
    },
    RATING: {
        header: {
            classes: 'track-row-header track-row-rating__header',
            label: 'Rating',
        },
        sortIdentifier: 'rating',
        render: rawTrack => RenderDesktopColumns.trackRating(RenderDesktopColumns.getTrackData(rawTrack).rating),
    },
    INFO_ICONS: {
        header: {
            classes: 'track-row-header track-row-info-icons__header',
            label: '',
        },
        render: rawTrack => RenderDesktopColumns.infoIcons(RenderDesktopColumns.getTrackData(rawTrack)),
    },
    TRACK_OPTIONS: {
        header: {
            classes: '',
            label: '',
        },
        render: () => RenderDesktopColumns.trackOptions(),
    },
};

export {columns, RenderDesktopColumns};
