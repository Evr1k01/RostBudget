export default {
    namespaced: true,

    state: {
        currency: 'EUR'
    },

    mutations: {
        setCurrency(state: {currency: string}, payload: string) {
            state.currency = payload
        }
    },

    actions: {

    },

    getters: {
        getCurrency(state: {currency: string}) {
            return state.currency
        }
    }
}
