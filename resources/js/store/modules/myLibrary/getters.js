import clusterizeTracks from './helpers/clusterizeTracks';

export default {
    playlists: state => state.playlists,
    playlistsInitialized: state => state.playlistsInitialized,
    tracks: state => state.tracks,
    tracksInitialized: state => state.tracksInitialized,
    tracksClusterized: state => clusterizeTracks(state.tracks),
    topArtists: state => state.topArtists,
    topArtistsInitialized: state => state.topArtistsInitialized,
}
