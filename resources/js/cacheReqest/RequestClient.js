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

    async fetchAudioAnalytics(url) {
        const response = await axios.get(url);
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

    async fetchArtist(artistId) {
        const response = await axios.get(`/api/artist/${artistId}`);
        return response.data;
    }

    async fetchArtists(artistIds, url = null) {
        const response = await axios.get(`/api/artists/${artistIds.join(',')}`);
        return response.data;
    }
}
