class RenderDesktopColumns {
    static trackTitle(rawTrack, showQueueIndicators) {
        let content = rawTrack.trackData.name;
        if (showQueueIndicators && rawTrack.queueIndex !== undefined) {
            content += ` <span class="track-row-title-queue-indicator">${rawTrack.queueIndex + 1}</span>`
        }
        return `<div class="track-row-title">${content}</div>`;
    }
}

const columns = {
    TRACK_TITLE: {
        label: 'Title',
        render: (rawTrack, options) => RenderDesktopColumns.trackTitle(rawTrack, options.is('showQueueIndicators'))
    },
};

export {columns};
