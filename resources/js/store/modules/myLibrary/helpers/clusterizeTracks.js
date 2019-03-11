const clusterizeTracks = function (tracks) {
    return tracks.reduce((rows, track, index) => rows.concat([
        `<div class="track is-unselectable" data-id="${track.id}" tabindex="1">` +
        `<div class="track-list-number">&nbsp;<span>${index + 1}.</span></div>` +
        `<div class="track-list-title">&nbsp;<span title="${track.name}">${track.name}</span></div>` +
        `<div class="track-list-duration">&nbsp;<span>${track.duration_formatted}</span></div>` +
        `<div class="track-list-artist">&nbsp;<span title="${track.artist.name}">${track.artist.name}</span></div>` +
        `<div class="track-list-rating">&nbsp;Star rating</div>` +
        `<div class="flex-1 track-list-options-trigger"></div>` +
        `<div class="track-list-options-trigger"><span class="icon has-text-grey-light" title="Spotify"><i class="mdi mdi-spotify mdi-24px"></i></span></div>` +
        `<div class="track-list-options-trigger"><span class="icon has-text-grey-light" title="Subscribed from Timi Hendrix"><i class="mdi mdi-account-multiple mdi-24px"></i></span></div>` +
        `<div class="flex-1 track-list-options-trigger"></div>` +
        `<div class="track-list-more-options"><span class="icon has-text-grey-light pointer" title="More options"><i class="mdi mdi-dots-vertical mdi-24px"></i></span></div>` +
        `</div>`
    ]), []);
};

export default clusterizeTracks;
