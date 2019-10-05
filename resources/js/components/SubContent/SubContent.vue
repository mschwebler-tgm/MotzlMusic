<template xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    <v-layout column fill-height>
        <v-flex shrink class="pb-0">
            <v-layout justify-end>
                <v-flex shrink>
                    <v-tooltip left>
                        <template v-slot:activator="{ on }">
                            <v-btn text icon v-on="on"
                                   :disabled="isInEditMode"
                                   @click="activateEditMode"
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
                <Container @drop="onDrop" lock-axis="y" v-if="isInEditMode" group-name="sub-content">
                    <Draggable v-for="(content, index) in subContentEditClone"
                               :key="content.randomId">
                        <v-flex shrink :class="{'pt-0': index === 0}">
                            <v-card>
                                <component :is="content.component"></component>
                                <v-overlay :value="true" class="move-cursor" absolute color="primary"></v-overlay>
                            </v-card>
                        </v-flex>
                    </Draggable>
                </Container>
                <template v-else>
                    <v-flex v-for="(content, index) in subContent"
                            :key="content.randomId"
                            shrink
                            :class="{'pt-0': index === 0}">
                        <v-card>
                            <component :is="content.component"></component>
                        </v-card>
                    </v-flex>
                </template>
            </v-layout>
        </v-flex>
    </v-layout>
</template>

<script>
    import AudioFeatures from "./Components/AudioFeatures";
    import PlayerControls from "./Components/PlayerControls";
    import TrackInfo from "./Components/TrackInfo";
    import {Container, Draggable} from "vue-smooth-dnd";

    export default {
        name: "SubContent",
        components: {TrackInfo, PlayerControls, AudioFeatures, Container, Draggable},
        methods: {
            onDrop(dropResult) {
                if (!dropResult.removedIndex) {
                    this.addComponent(dropResult.addedIndex, dropResult.payload);
                } else {
                    this.moveContent(dropResult.removedIndex, dropResult.addedIndex);
                }
            },
            addComponent(index, component) {
                const newComponent = {
                    id: Math.random().toString(36).substring(7),
                    component,
                };
                this.subContentEditClone.splice(index, 0, newComponent);
            },
            moveContent(fromIndex, toIndex) {
                this.arrayMove(this.subContentEditClone, fromIndex, toIndex);
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
            activateEditMode() {
                this.$store.commit('subContent/activateEditMode');
            }
        },
        computed: {
            isInEditMode() {
                return this.$store.getters['subContent/isInEditMode'];
            },
            subContent() {
                return this.$store.getters['subContent/subContent'];
            },
            subContentEditClone() {
                return this.$store.getters['subContent/subContentEditClone'];
            },
        },
    }
</script>

<style scoped>

</style>
