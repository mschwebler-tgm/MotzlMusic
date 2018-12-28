import clusterizeTracks from '../../../util/clusterizeTracks';

export default {
    playlists: state => state.playlists,
    tracks: state => state.tracks,
    tracksInitialized: state => state.tracksInitialized,
    tracksClusterized: state => clusterizeTracks(state.tracks),
}
