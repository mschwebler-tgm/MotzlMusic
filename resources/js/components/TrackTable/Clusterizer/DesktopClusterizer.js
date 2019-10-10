export default class DesktopClusterizer {

    generateForTracks(tracks) {
        const trackRows = tracks.map(() => '<div class="track-row"></div>');
        return trackRows.join('');
    }
}
