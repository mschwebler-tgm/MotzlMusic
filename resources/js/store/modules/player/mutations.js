import app from '../../../app'
import player from "./helpers/v2/player";

export default {
    addTrackToQueue(state, track) {
        const wasQueued = player.queueTrack(track);
        if (wasQueued) {
            app.showAlert('1 track added to queue');
        }
    },
}
