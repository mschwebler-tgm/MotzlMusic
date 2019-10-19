import Track from "$store/player/helpers/v2/Track";

class RenderMobileColumns {
    static getTrackData(rawTrack) {
        if (rawTrack instanceof Track) {
            return rawTrack.trackData;
        }
        return rawTrack;
    }

    static titleAndArtist(rawTrack, options) {
        const trackData = RenderMobileColumns.getTrackData(rawTrack);
        let title = trackData.name;
        if (rawTrack instanceof Track && options.is('showQueueIndicators') && rawTrack.isQueued) {
            title += ` <div class="track-row-title-queue-indicator">${rawTrack.queueIndex + 1}</div>`
        }
        const artistNames = trackData.artists.map(artist => artist.name).join(', ');

        return `<div class="track-row-title-and-artist text-truncate">` +
            `<div class="track-row-title">${title}</div>` +
            `<div class="track-row-artist">${artistNames}</div>` +
            `</div>`;
    }

    static albumImage(imageSrc) {
        return `<div class="track-row-image"><img src="${imageSrc}" alt=""></div>`;
    }

    static trackDuration(durationFormatted) {
        return `<div class="track-row-duration">${durationFormatted}</div>`;
    }

    static trackOptions() {
        return `<div class="track-row-options-mobile"><span class="icon has-text-grey-light pointer" title="More options"><i class="mdi mdi-dots-vertical mdi-24px track-options"></i></span></div>`;
    }
}

const columns = {
    TITLE_AND_ARTIST: {
        label: '#',
        render: (rawTrack, options) => RenderMobileColumns.titleAndArtist(rawTrack, options),
    },
    ALBUM_IMAGE: {
        label: '',
        render: rawTrack => RenderMobileColumns.albumImage(RenderMobileColumns.getTrackData(rawTrack).album.spotify_image_small),
    },
    DURATION: {
        label: '',
        render: rawTrack => RenderMobileColumns.trackDuration(RenderMobileColumns.getTrackData(rawTrack).duration_formatted),
    },
    TRACK_OPTIONS: {
        label: '',
        render: () => RenderMobileColumns.trackOptions(),
    },
};

export {columns, RenderMobileColumns};
