import DesktopClusterizer from "$scripts/components/TrackTable/Clusterizer/DesktopClusterizer";

describe('DesktopClusterizer', () => {
    it('should generate a div container for a row', () => {
        const clusterizer = new DesktopClusterizer();
        const tracks = [{id: 1}];

        const htmlContent = clusterizer.generateForTracks(tracks);

        expect(htmlContent).toContain('div');
        expect(htmlContent).toContain('class="track-row"');
    });

    it('should generate draggable container surrounding track rows if drag is enabled', () => {
        const clusterizer = new DesktopClusterizer();
        clusterizer.configure({draggable: true});

        const htmlContent = clusterizer.generateForTracks([]);

        expect(htmlContent).toContain(`div id="${clusterizer._dragContainerId}"`);
    });

    it('should throw error if invalid option is provided', () => {
        const clusterizer = new DesktopClusterizer();

        expect(() => clusterizer.configure({iDoNotExist: true}))
            .toThrowError();
    });
});
