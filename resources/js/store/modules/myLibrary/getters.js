export default {
    playlists: state => state.playlists,
    tracks: state => state.tracks,
    tracksInitialized: state => state.tracksInitialized,
    tracksClusterized: state => clusterizeTracks(state.tracks),
}

function clusterizeTracks(tracks) {
    return tracks.reduce((rows, track, index) => rows.concat([
        `<div class="track">` +
            `<div class="track-list-number">&nbsp;<span>${index + 1}</span></div>` +
            `<div class="track-list-title">&nbsp;<span title="${track.name}">${track.name}</span></div>` +
            `<div class="track-list-duration">&nbsp;<span>${track.duration_formatted}</span></div>` +
            `<div class="track-list-artist">&nbsp;<span title="${track.artist.name}">${track.artist.name}</span></div>` +
        `</div>`
        ]), []);
}
