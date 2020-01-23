<template>
    <div class="header d-flex align-center">
        <div v-for="(column, index) in columns"
             :key="index"
             v-html="column.label"
             @click="sortBy(column.sortIdentifier)"
             class="grey--text">
        </div>
    </div>
</template>

<script>
    class Sort {
        constructor(identifier, direction = 'asc') {
            this.identifier = identifier;
            this.direction = direction;
        }
    }

    export default {
        name: "BaseTrackTableHeaders",
        props: {
            columns: Array,
        },
        data() {
            return {
                sorting: [],
            }
        },
        methods: {
            sortBy(identifier) {
                if (!identifier) {
                    return;
                }

                const existingSortIndex = this.sorting.findIndex(sort => sort.identifier === identifier);
                const existingSort = this.sorting[existingSortIndex];
                if (existingSort) {
                    if (existingSort.direction === 'desc') {
                        this.sorting.splice(existingSortIndex, 1);
                    } else {
                        existingSort.direction = 'desc';
                    }
                } else {
                    this.sorting.push(new Sort(identifier));
                }

                this.$emit('input', this.sorting);
            }
        }
    }
</script>
