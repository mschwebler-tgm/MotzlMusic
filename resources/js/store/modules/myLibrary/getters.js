import clusterizeTracks from './helpers/clusterizeTracks';

export default {
    playlists: state => state.playlists,
    playlistsInitialized: state => state.playlistsInitialized,
    tracks: state => state.tracks,
    tracksInitialized: state => state.tracksInitialized,
    tracksClusterized: state => clusterizeTracks(state.tracks),
    artists: state => state.artists,
    artistsInitialized: state => state.artistsInitialized,
    albums: state => state.albums,
    albumsInitialized: state => state.albumsInitialized,
}
