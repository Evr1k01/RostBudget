import {ActionContext} from "vuex";
interface IState {
    drawer: boolean
}

export default {
    namespaced: true,

    state: {
        drawer: false
    },

    mutations: {
        setDrawerSuccessful(state: IState) {
            state.drawer = !state.drawer
        }
    },

    actions: {
        setDrawer(context: ActionContext<any, any>) {
            context.commit('setDrawerSuccessful')
        }
    },

    getters: {
        getDrawer(state: IState) {
            return state.drawer
        }
    }
}
