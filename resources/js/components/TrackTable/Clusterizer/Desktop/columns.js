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
        if (rawTrack instanceof Track && options.is('showQueueIndicators') && rawTrack.queueIndex !== undefined) {
            content += ` <span class="track-row-title-queue-indicator">${rawTrack.queueIndex + 1}</span>`
        }
        return `<div class="track-row-title">${content}</div>`;
    }

    static trackAlbum(albumName) {
        return `<div class="track-row-album">${albumName}</div>`;
    }

    static albumImage(imageSrc) {
        return `<div class="track-row-image"><img src="${imageSrc}" alt=""></div>`;
    }

    static trackArtists(artists) {
        const artistNames = artists.map(artist => artist.name).join(', ');
        return `<div class="track-row-artist">${artistNames}</div>`;
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

        return `<div class="track-list-info-icons">${icons}</div>`;
    }
}

const columns = {
    INDEX: {
        label: '#',
        render: (rawTrack, options, index) => RenderDesktopColumns.trackIndex(index),
    },
    TRACK_TITLE: {
        label: 'Title',
        render: (rawTrack, options) => RenderDesktopColumns.trackTitle(rawTrack, options),
    },
    ALBUM_TITLE: {
        label: 'Album',
        render: rawTrack => RenderDesktopColumns.trackAlbum(RenderDesktopColumns.getTrackData(rawTrack).album.name),
    },
    ALBUM_IMAGE: {
        label: '',
        render: rawTrack => RenderDesktopColumns.albumImage(RenderDesktopColumns.getTrackData(rawTrack).album.spotify_image_small),
    },
    ARTISTS: {
        label: 'Artists',
        render: rawTrack => RenderDesktopColumns.trackArtists(RenderDesktopColumns.getTrackData(rawTrack).artists),
    },
    ARTIST: {
        label: 'Artist',
        render: rawTrack => RenderDesktopColumns.trackArtists([RenderDesktopColumns.getTrackData(rawTrack).artists[0]]),
    },
    DURATION: {
        label: '',
        render: rawTrack => RenderDesktopColumns.trackDuration(RenderDesktopColumns.getTrackData(rawTrack).duration_formatted),
    },
    RATING: {
        label: 'Rating',
        render: rawTrack => RenderDesktopColumns.trackRating(RenderDesktopColumns.getTrackData(rawTrack).rating),
    },
    INFO_ICONS: {
        label: '',
        render: rawTrack => RenderDesktopColumns.infoIcons(RenderDesktopColumns.getTrackData(rawTrack)),
    }
};

export {columns};
