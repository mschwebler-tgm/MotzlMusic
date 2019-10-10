class RenderDesktopColumns {
    static trackTitle(rawTrack) {
        return `<div class="track-row-title">${rawTrack.trackData.name}</div>`;
    }
}

const columns = {
    TRACK_TITLE: {
        label: 'Title',
        render: rawTrack => RenderDesktopColumns.trackTitle(rawTrack)
    },
};

export {columns};
