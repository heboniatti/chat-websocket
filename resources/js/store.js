import Axios from "axios";
import Vue from "vue";
import Vuex from "vuex";
import createPersistedState from "vuex-persistedstate";

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        user: {}
    },
    mutations: {
        setUserState(state, value) {
            state.user = value;
        }
    },
    actions: {
        userStateAction() {
            Axios.get("api/user/me").then(r => {
                const userResponse = r.data.user;
                this.commit("setUserState", userResponse);
            });
        }
    },
    plugins: [createPersistedState()]
});
