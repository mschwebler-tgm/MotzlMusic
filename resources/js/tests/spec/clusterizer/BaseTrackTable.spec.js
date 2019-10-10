import { mount } from '@vue/test-utils';
import BaseTrackTable2 from "$scripts/components/TrackTable/BaseTrackTable2";

describe('BaseTrackTable', () => {
    it('should should contain divs needed for clusterize.js', () => {
        const wrapper = mount(BaseTrackTable2);

        expect(wrapper.contains('.clusterize-scroll')).toBe(true);
        expect(wrapper.contains('.clusterize-content')).toBe(true);
    });
});
