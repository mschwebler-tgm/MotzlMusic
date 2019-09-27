<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-layout column fill-height>
        <v-flex shrink class="pb-0">
            <v-layout justify-end>
                <v-flex shrink>
                    <v-tooltip left>
                        <template v-slot:activator="{ on }">
                            <v-btn text icon v-on="on"
                                   @click="$root.subContentEditModeActive = !$root.subContentEditModeActive"
                                   aria-label="Settings" class="mt-2 mb-3">
                                <v-icon>settings</v-icon>
                            </v-btn>
                        </template>
                        <span>Configure Sub Content</span>
                    </v-tooltip>
                </v-flex>
            </v-layout>
        </v-flex>
        <v-flex grow fill-height>
            <v-layout column class="fill-height">
                <Container @drop="moveContent" lock-axis="y" v-if="$root.subContentEditModeActive">
                    <Draggable v-for="(content, index) in subContent"
                               :key="content.component">
                        <v-flex shrink :class="{'pt-0': index === 0}">
                            <v-card>
                                <component :is="content.component"></component>
                                <v-overlay :value="$root.subContentEditModeActive" absolute color="primary"></v-overlay>
                            </v-card>
                        </v-flex>
                    </Draggable>
                </Container>
                <template v-else>
                    <v-flex v-for="(content, index) in subContent"
                            :key="content.component"
                            shrink
                            :class="{'pt-0': index === 0}">
                        <v-card>
                            <component :is="content.component"></component>
                            <v-overlay :value="$root.subContentEditModeActive" absolute color="primary"></v-overlay>
                        </v-card>
                    </v-flex>
                </template>
            </v-layout>
        </v-flex>
    </v-layout>
</template>

<script>
    const defaultSubContent = [
        {
            component: 'audio-features',
        },
        {
            component: 'player-controls',
        },
        {
            component: 'track-info',
        },
    ];

    import AudioFeatures from "./Components/AudioFeatures";
    import PlayerControls from "./Components/PlayerControls";
    import TrackInfo from "./Components/TrackInfo";
    import {Container, Draggable} from "vue-smooth-dnd";

    export default {
        name: "SubContent",
        components: {TrackInfo, PlayerControls, AudioFeatures, Container, Draggable},
        data() {
            return {
                subContent: JSON.parse(localStorage.getItem('subContent')) || [],
            }
        },
        created() {
            if (!localStorage.getItem('subContent')) {
                this.subContent = defaultSubContent;
            }
        },
        watch: {
            subContent(content) {
                localStorage.setItem('subContent', JSON.stringify(content));
            }
        },
        methods: {
            moveContent(dropResult) {
                this.arrayMove(this.subContent, dropResult.removedIndex, dropResult.addedIndex);
            },
            arrayMove(array, oldIndex, newIndex) {
                if (newIndex >= array.length) {
                    let k = newIndex - array.length + 1;
                    while (k--) {
                        array.push(undefined);
                    }
                }
                array.splice(newIndex, 0, array.splice(oldIndex, 1)[0]);
            },
        }
    }
</script>

<style scoped>

</style>
