import DesktopClusterizer from "$scripts/components/TrackTable/Clusterizer/DesktopClusterizer";

describe('DesktopClusterizer', () => {
    it('should generate a div container for a row', () => {
        const clusterizer = new DesktopClusterizer();
        const tracks = [{id: 1}];

        const htmlContent = clusterizer.generateForTracks(tracks);

        expect(htmlContent).toContain('div');
        expect(htmlContent).toContain('class="track-row"');
    });
});
