const defaultOptions = {
    showQueueIndicators: true,
    activeByPlayingTrackListIndex: false,
    mobileColumns: [],
    desktopColumns: [],
    activatable: true,
    contextMenu: true,
    playable: true,
    queueable: true,
    desktop: true,
    draggable: false,
    draggableOptions: {},
};

const availableOptions = Object.keys(defaultOptions);

export {defaultOptions, availableOptions};
