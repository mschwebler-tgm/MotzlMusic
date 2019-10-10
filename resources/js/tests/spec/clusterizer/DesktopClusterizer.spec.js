import DesktopClusterizer from "$scripts/components/TrackTable/Clusterizer/Desktop/DesktopClusterizer";
import {columns} from "$scripts/components/TrackTable/Clusterizer/Desktop/columns";
import ClusterizeOptions from "$scripts/components/TrackTable/Clusterizer/ClusterizeOptions";

describe('DesktopClusterizer', () => {
    it('should generate a div container for a row', () => {
        const clusterizer = new DesktopClusterizer(new ClusterizeOptions());
        const tracks = [{trackData: {id: 1}}];

        const htmlContent = clusterizer.generateForTracks(tracks)[0];

        expect(htmlContent).toContain('div');
        expect(htmlContent).toContain('class="track-row"');
    });

    it('should throw error if invalid option is provided', () => {
        const clusterizer = new DesktopClusterizer(new ClusterizeOptions());

        expect(() => clusterizer.configure({iDoNotExist: true}))
            .toThrowError();
    });

    it('should render track title column', () => {
        const clusterizer = new DesktopClusterizer(new ClusterizeOptions());
        clusterizer.configure({columns: [columns.TRACK_TITLE]});
        const name = 'test track';

        const htmlContent = clusterizer.generateForTracks([{trackData: {name}}])[0];

        expect(htmlContent).toContain('track-row-title');
        expect(htmlContent).toContain(name);
    });

    it('should show queue indicator on title column', () => {
        const clusterizer = new DesktopClusterizer(new ClusterizeOptions());
        clusterizer.configure({columns: [columns.TRACK_TITLE]});
        const name = 'test track';
        const queueIndex = 5;

        const htmlContent = clusterizer.generateForTracks([{trackData: {name}, queueIndex}])[0];

        expect(htmlContent).toContain('track-row-title-queue-indicator');
        expect(htmlContent).toContain(queueIndex + 1);
    });
});
