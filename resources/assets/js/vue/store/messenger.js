// Message Store
export default {
    namespaced: true,
    
    state: {
        threads: [],
        currentThread: [],
        unreadThreads:[],
    },
    
    mutations: {
        removeReadThread(state, index){
            state.unreadThreads.splice(index,1);
        },
        setThreads(state, threads) {
            state.threads = threads;
        },
        setUnreadThreads(state, threads) {
            state.unreadThreads=[];
            threads.forEach((thread)=>{
                if(thread.read_at===null){
                    state.unreadThreads.push(thread);
                }
            })
        },

        addThread(state, thread) {
            state.threads.push(thread);
        },

        setCurrentThread(state, thread) {
            state.currentThread = thread;
        },

        newMessageInThread(state, payload) {
            // state.threads.forEach(item => {
                const { thread, message } = payload;

                if (state.currentThread.id == 1) {
                    state.currentThread.messages.push(message);
                }
            // });
        }
    },
    
    actions: {
        fetchThreads({ commit }) {
            axios.get('/api/threads/mine')
                 .then(response => {
                                    commit('setThreads', response.data);
                                    commit('setUnreadThreads', response.data);
                                })
                 .catch(error => console.log(error));
        },

        getCurrentThread({ commit,dispatch }, id) {
            axios.get(`/api/thread/${id}`)
                 .then(response => {
                    commit('setCurrentThread', response.data);
                    dispatch('fetchThreads'); //to get latest unread messages for top dropdown
                })
                 .catch(error => console.log(error))
        },

        markread({commit}, payload){
            //send ajax call to mark thread as read for current user
            axios.get(`/api/thread/markread/${payload.id}`)
                 .then(response => {
                        commit('removeReadThread', payload.index)
                    })
                 .catch(error => console.log(error))
            //remove the message from unreadThreads array
            console.log(payload.id,payload.index);
        }
    }
}
