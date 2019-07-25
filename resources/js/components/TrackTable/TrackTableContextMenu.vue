<template>
    <component :is="menuComponent" v-bind="$attrs"
               v-model="show"
               :position-x="optionMenuPositionX"
               :position-y="optionMenuPositionY"
               offset-x
               absolute>
        <v-list light :dense="isDense">
            <v-list-item @click="addToQueue">
                <v-list-item-icon>
                    <v-icon small>add_to_queue</v-icon>
                </v-list-item-icon>
                <v-list-item-title>
                    Add to Queue
                </v-list-item-title>
            </v-list-item>
            <v-list-item @click="show = false">
                <v-list-item-icon>
                    <v-icon small>playlist_add</v-icon>
                </v-list-item-icon>
                <v-list-item-title>
                    Add to Playlist
                </v-list-item-title>
            </v-list-item>
            <v-divider></v-divider>
            <v-list-item @click="removeTrackFromLibrary">
                <v-list-item-icon>
                    <v-icon small>delete</v-icon>
                </v-list-item-icon>
                <v-list-item-title>
                    Remove from your Library
                </v-list-item-title>
            </v-list-item>
            <v-list-item @click="show = false">
                <v-list-item-icon>
                    <v-icon small>edit</v-icon>
                </v-list-item-icon>
                <v-list-item-title>
                    Edit
                </v-list-item-title>
            </v-list-item>
        </v-list>
    </component>
</template>

<script>
    export default {
        name: "TrackTableContextMenu",
        props: ['tableId'],
        data() {
            return {
                track: null,
                show: false,
                optionMenuPositionX: 0,
                optionMenuPositionY: 0,
            }
        },
        computed: {
            menuComponent() {
                return this.$root.isTouch ? 'v-bottom-sheet' : 'v-menu';
            },
            isDense() {
                return !this.$root.isTouch;
            }
        },
        mounted() {
            this.initTouchMenuListener();
            this.initMenuListener();
        },
        methods: {
            addToQueue() {
                this.show = false;
                this.$store.commit('player/addTrackToQueue', this.track);
            },
            removeTrackFromLibrary() {
                this.show = false;
                setTimeout(() => {
                    this.$store.dispatch('myLibrary/removeTrack', this.track.id);
                }, 30);
            },
            initMenuListener() {
                const table = document.getElementById(this.tableId);
                table.addEventListener('contextmenu', $event => this.handleTrackOptionsClick($event));
                table.addEventListener('click', $event => {
                    if ($event.target.classList.contains('track-options')) {
                        this.handleTrackOptionsClick($event);
                    }
                })
            },
            handleTrackOptionsClick($event) {
                $event.preventDefault();
                const trackElement = this.$parent.findTrackElement($event.target);
                this.track = this.$parent.getTrackFromDomElement(trackElement);
                this.optionMenuPositionX = $event.clientX;
                this.optionMenuPositionY = $event.clientY;
                this.show = true;
            },
            initTouchMenuListener() {
                const onLongTouch = ($event) => {
                    this.handleTrackOptionsClick($event);
                    this.vibrateDevice(50);
                };
                let timer;
                let touchDuration = 500;
                const table = document.getElementById(this.tableId);
                table.addEventListener('touchstart', $event => {
                    timer = setTimeout(() => onLongTouch($event), touchDuration)
                });
                table.addEventListener('touchend', () => timer && clearTimeout(timer));
                table.addEventListener('scroll', () => timer && clearTimeout(timer));
            },
            vibrateDevice(durationMs) {
                if (navigator.vibrate) {
                    navigator.vibrate(durationMs);
                }
            },
        }
    }
</script>
