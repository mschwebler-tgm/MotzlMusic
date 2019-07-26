export default {
    init() {
    },
    play({state}, track) {
        // TODO validateTrack: play track before validating? load artist and album afterwards?
        updateActiveTrackClass(track, state.playerController.playingTrack);
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
    playList({state, dispatch}, {type, list}) {
        state.playerController.loading = true;
        state.activeItem = {type, id: list.id};
        if (!list.tracks) {
            axios.get(`/api/${type}/${list.id}/tracks`)
                .then(res => list.tracks = res.data)
                .then(() => dispatch('playQueue', list.tracks));
        } else {
            dispatch('playQueue', list.tracks);
        }
    },
    addSelectedToQueue({rootState, commit}) {
        const focusedItems = rootState.subContent.focusedItems;
        const focusedTracks = focusedItems.filter(item => item.type === 'track');  // only allow tracks to be queued for now
        focusedTracks.forEach(track => commit('addTrackToQueue', track));
    },
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

function updateActiveTrackClass(newTrack, oldTrack) {
    if (oldTrack) {
        const trackRows = [...document.getElementsByClassName(`track-row-${oldTrack.id}`)];
        trackRows.forEach($row => $row.classList.remove('active'));
    }
    if (newTrack) {
        const trackRows = [...document.getElementsByClassName(`track-row-${newTrack.id}`)];
        trackRows.forEach($row => $row.classList.add('active'));
    }
}
