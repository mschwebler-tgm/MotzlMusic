export default {
    init() {
    },
    play({state}, track) {
        // TODO validateTrack: play track before validating? load artist and album afterwards?
        validateTrack(track).then(() => {
            return state.playerController.play(track);
        });
    },
    pause({state}) {
        state.playerController.pause();
    },
    playQueue({state, dispatch}, trackList) {
        if (trackList.length === 0) {
            return;
        }

        state.queueController.queue = trackList;
        dispatch('play', trackList[0]);
    },
    playNext({state, dispatch}) {
        state.queueController.setNext();
        return dispatch('play', state.queueController.currentTrack);
    },
    playPrevious({state, dispatch}) {
        state.queueController.setPrevious();
        dispatch('play', state.queueController.currentTrack);
    },
    playPlaylist({state, dispatch}, playlist) {
        dispatch('playQueue');
        state.playerController.loading = true;
        state.activeItem = {type: 'playlist', id: playlist.id};
        if (!playlist.tracks) {
            axios.get(`/api/playlist/${playlist.id}/tracks`)
                .then(res => playlist.tracks = res.data)
                .then(() => dispatch('playQueue', playlist.tracks));
        } else {
            dispatch('playQueue', playlist.tracks);
        }
    },
    playAlbum({state, dispatch}, album) {
        state.playerController.loading = true;
        state.activeItem = {type: 'album', id: album.id};
        if (!album.tracks) {
            axios.get(`/api/album/${album.id}/tracks`)
                .then(res => album.tracks = res.data)
                .then(() => dispatch('playQueue', album.tracks));
        } else {
            dispatch('playQueue', album.tracks);
        }
    },
    playArtist({state, dispatch}, artist) {
        state.playerController.loading = true;
        state.activeItem = {type: 'artist', id: artist.id};
        if (!artist.tracks) {
            axios.get(`/api/artist/${artist.id}`)
                .then(res => artist.tracks = res.data)
                .then(() => dispatch('playQueue', artist.tracks));
        } else {
            dispatch('playQueue', artist.tracks);
        }
    }
}

function validateTrack(track) {
    return new Promise((resolve, reject) => {
        if (!track) {
            resolve();  // playback will be resumed
        }
        axios.get(`/api/track/${track.id}`)
            .then(res => {
                track.album = res.data.album;
                track.artists = res.data.artists;
            })
            .then(resolve)
            .catch(reject);
    });
}