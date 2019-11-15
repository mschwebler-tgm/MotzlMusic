const MAX_FETCH_ITEMS_COUNT = 30;

export default class RequestClient {
    async fetchTrack(id) {
        const response = await axios.get('/api/track/' + id);
        return response.data;
    }

    async fetchTracks(ids, url = null) {
        let response;
        if (ids.length > MAX_FETCH_ITEMS_COUNT && url) {
            response = await axios.get(url);
        } else {
            response = await axios.get('/api/tracks/' + ids.join(','));
        }

        return response.data;
    }

    async fetchAudioAnalytics(trackId) {
        const response = await axios.get(`/api/track/${trackId}/audio-features`);
        return response.data;
    }

    async fetchAlbum(albumId) {
        const response = await axios.get(`/api/album/${albumId}`);
        return response.data;
    }

    async fetchAlbums(albumIds, url = null) {
        const response = await axios.get(`/api/albums/${albumIds.join(',')}`);
        return response.data;
    }
}
