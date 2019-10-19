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
        <v-flex grow fill-height class="y-scroll">
            <v-layout column class="fill-height">
                <Container v-if="isInEditMode"
                           remove-on-drop-out
                           @drop="onDrop"
                           group-name="sub-content"
                           class="h-100">
                    <Draggable v-for="(content, index) in subContentEditClone"
                               :key="content.randomId">
                        <v-flex shrink :class="{'pt-0': index === 0}">
                            <v-card class="relative">
                                <component :is="content.component"></component>
                                <div class="sub-content-overlay move-cursor">
                                    <v-btn small
                                           @click="removeContent(index)"
                                           class="remove-content-button">
                                        <v-icon small>close</v-icon>
                                    </v-btn>
                                </div>
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
    import {Container, Draggable} from "vue-smooth-dnd";

    export default {
        name: "SubContent",
        components: {Container, Draggable},
        methods: {
            onDrop(dropResult) {
                const removedIndex = dropResult.removedIndex;
                const addedIndex = dropResult.addedIndex;
                if (removedIndex === null && addedIndex !== null) {
                    this.addComponent(addedIndex, dropResult.payload);
                } else if (addedIndex === null && removedIndex !== null) {
                    this.removeContent(removedIndex);
                } else if (removedIndex !== null && addedIndex !== null) {
                    this.moveContent(removedIndex, addedIndex);
                }
            },
            removeContent(index) {
                this.subContentEditClone.splice(index, 1);
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

<!--suppress CssUnresolvedCustomProperty -->
<style scoped>
    .sub-content-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: var(--v-primary-base);
        opacity: 0.46;
        border-radius: inherit;
    }

    .sub-content-overlay:hover .remove-content-button {
        display: block;
    }

    .remove-content-button {
        display: none;
        position: absolute;
        top: 0;
        right: 0;
    }
</style>
