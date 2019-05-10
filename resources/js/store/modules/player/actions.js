export default {
    init() {
    },
    play({state}, track) {
        state.playerController.play(track);
    },
    pause({state}) {
        state.playerController.pause();
    },
    playNext({state, dispatch}) {
        state.queueController.setNext();
        dispatch('play', state.queueController.currentTrack);
    },
    playPrevious({state, dispatch}) {
        state.queueController.setPrevious();
        dispatch('play', state.queueController.currentTrack);
    },
    playPlaylist({state, dispatch}, playlist) {
        state.playerController.loading = true;
        state.activePlaylistId = playlist.id;
        if (!playlist.tracks) {
            axios.get(`/api/playlist/${playlist.id}/tracks`)
                .then(res => playlist.tracks = res.data)
                .then(() => playPlaylist());
        } else {
            playPlaylist();
        }

        function playPlaylist() {
            state.queueController.queue = playlist.tracks;
            dispatch('play', playlist.tracks[0]);
        }
    }
}
