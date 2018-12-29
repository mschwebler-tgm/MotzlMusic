import clusterizeTracks from './helpers/clusterizeTracks';
import clusterizeArtists from './helpers/clusterizeArtists';

export default {
    playlists: state => state.playlists,
    playlistsInitialized: state => state.playlistsInitialized,
    tracks: state => state.tracks,
    tracksInitialized: state => state.tracksInitialized,
    tracksClusterized: state => clusterizeTracks(state.tracks),
}
