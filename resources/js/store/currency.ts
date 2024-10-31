import axios$ from "../axios-instance.js"
import {ActionContext} from "vuex";
interface ICurrency {
    id: string,
    currencyCode: string
}

interface ICurrencyState {
    currency: string,
    list: ICurrency[]
}

export default {
    namespaced: true,

    state: {
        currency: 'EUR',
        list: []
    },

    mutations: {
        currencySuccess(state: ICurrencyState, payload: string) {
            state.currency = payload
        },

        listSuccess(state: ICurrencyState, payload: ICurrency[]) {
            state.list = payload
        }
    },

    actions: {
        async getList(context: ActionContext<any, any>): Promise<void> {
            return new Promise((resolve, reject) => {
                axios$.get('currencies')
                    .then(response => {
                        context.commit('listSuccess', response.data.data)
                        resolve()
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        async getCurrency(context: ActionContext<any, any>): Promise<void> {
            return new Promise((resolve, reject) => {
                axios$.get('get-user-currency')
                    .then(response => {
                        const currencyCode = response.data.data.currencyCode
                        context.commit('currencySuccess', currencyCode)
                        resolve()
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },

        async setCurrency(context: ActionContext<any, any>, payload: {currencyId: string}): Promise<void> {
            return new Promise((resolve, reject) => {
                axios$.post('set-user-currency', payload)
                    .then(response => {
                        const currencyCode = response.data.data.currencyCode
                        context.commit('currencySuccess', currencyCode)
                        resolve()
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        }
    },

    getters: {
        getList(state: ICurrencyState) {
            return state.list
        },

        getCurrency(state: ICurrencyState) {
            return state.currency
        }
    }
}
