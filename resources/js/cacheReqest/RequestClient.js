export default class RequestClient {
    async fetchTrack(id) {
        const response = await axios.get('/api/track/' + id);
        return response.data;
    }

    async fetchAudioAnalytics(trackId) {
        const response = await axios.get(`/api/track/${trackId}/audio-features`);
        return response.data;
    }
}
