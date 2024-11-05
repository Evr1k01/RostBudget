import axios$ from '../axios-instance.js'
import {ActionContext} from "vuex";
import IPurchase from "../interfaces/IPurchase";
export default {
    namespaced: true,

    state: {
         list: []
    },

    mutations: {
        listSuccess(state: {list: IPurchase[]}, payload: IPurchase[]) {
            state.list = payload
        },

        createSuccess(state: {list: IPurchase[]}, payload: IPurchase[]) {
            state.list = payload
        },

        updateSuccess(state: {list: IPurchase[]}, payload: IPurchase[]) {
            state.list = payload
        },

        deleteSuccess(state: {list: IPurchase[]}, payload: string) {
            let entityIndex = state.list.findIndex((item) => item.id === payload)
            if (entityIndex > -1) {
                state.list.splice(entityIndex, 1)
            }
        }
    },

    actions: {
        async getList(context: ActionContext<any, any>): Promise<void> {
            return new Promise((resolve, reject) => {
                axios$.get('purchases')
                    .then(response => {
                        context.commit('listSuccess', response.data.data)
                        resolve()
                    }).catch(error => {
                        console.log(error)
                        reject(error)
                })
            })
        },

        async storePurchase(context: ActionContext<any, any>, payload: IPurchase): Promise<void> {
            return new Promise((resolve, reject) => {
                if (!payload.id) {
                    axios$.post(`purchases`, payload)
                        .then((response) => {
                            context.commit('createSuccess', response.data.data)
                            resolve()
                        }).catch(error => {
                            console.log(error)
                            reject(error)
                        })
                } else {
                    axios$.put(`purchases/${payload.id}`, payload)
                        .then((response) => {
                            context.commit('updateSuccess', response.data.data)
                            resolve()
                        }).catch(error => {
                            console.log(error)
                            reject(error)
                        })
                }
            })
        },

        async deletePurchase(context: ActionContext<any, any>, payload: IPurchase): Promise<void> {
            return new Promise((resolve, reject) => {
                axios$.delete(`purchases/${payload.id}`)
                    .then(() => {
                        context.commit('deleteSuccess', payload.id)
                        resolve()
                    }).catch(error => {
                    reject(error)
                })
            })
        }
    },

    getters: {
        getList(state: {list: IPurchase[]}) {
            return state.list
        }
    }
}
