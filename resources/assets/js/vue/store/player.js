// Player Store

export default {
    namespaced: true,
    state: {
        track: {
            name: ''
        },
        status: {
            set: false,
            playing: false,
            dragging: false,
            muted: false,
            position: -1, // Percentage between 0 and 1
            time: {
                current: 0,
                max: -1, // Default
            }
        },
        repeat: false,
        shuffle: false,
    },
    mutations: {
        setCurrentTime(state, value) {
            state.status.time.current = value;
        },
        setMaxTime(state, value) {
            state.status.time.max = value;
        },
        setPosition(state, value) {
            state.status.position = value;
        },
        setPlaying(state, value) {
            state.status.playing = value;
        },
        setMuted(state, value) {
            state.status.muted = value;
        },
        setRepeat(state, value) {
            state.repeat = value;
        },
        setDragging(state, value) {
            state.status.dragging = value;
        },
        setTrack(state, value) {
            state.track = value;
            state.status.set = true;
        },
    },
    actions: {

    },
    getters: {
        getTrack(state) {
            return state.track
        },
        getTrackByType: (state) => (type) => {
            return state.track[type]
        }
    }
}
