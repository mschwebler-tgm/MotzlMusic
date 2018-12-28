export default {
    playlists: state => state.playlists,
    tracks: state => state.tracks,
    tracksInitialized: state => state.tracksInitialized,
    tracksClusterized: state => clusterizeTracks(state.tracks),
}

function clusterizeTracks(tracks) {
    return tracks.reduce((rows, track, index) => rows.concat([
        `<div class="track">` +
            `<div class="track-list-number">&nbsp;${index + 1}</div>` +
            `<div class="track-list-title">&nbsp;${track.name}</div>` +
            `<div class="track-list-duration">&nbsp;${track.duration_formatted}</div>` +
            `<div class="track-list-artist">&nbsp;${track.artist.name}</div>` +
        `</div>`
        ]), []);
}
