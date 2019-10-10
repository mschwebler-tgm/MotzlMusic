import {mount} from '@vue/test-utils';
import BaseTrackTable2 from "$scripts/components/TrackTable/BaseTrackTable2";

describe('BaseTrackTable', () => {
    it('should should contain divs needed for clusterize.js', () => {
        const wrapper = mount(BaseTrackTable2, {
            propsData: {
                tracks: [],
            },
            methods: {
                _initClusterizeJs: () => undefined
            },
            sync: true,
        });

        const scrollId = 'div#' + wrapper.vm.scrollId;
        const contentId = 'div#' + wrapper.vm.contentId;

        expect(wrapper.contains(scrollId)).toBe(true);
        expect(wrapper.contains(contentId)).toBe(true);
    });
});
