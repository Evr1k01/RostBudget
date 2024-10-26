import axios from '../axios-instance.js'
import {ActionContext} from "vuex";
import IPurchase from "../interfaces/IPurchase";
export default {
    namespaced: true,

    state: {
         list: []
    },

    mutations: {
        listSuccess(state: {list: any[]}, payload: IPurchase[]) {
            state.list = payload
        },

        createSuccess(state, payload) {

        },

        updateSuccess(state, payload) {

        }
    },

    actions: {
        async getList(context: ActionContext<any, any>): Promise<void> {
            return new Promise((resolve, reject) => {
                axios.get('purchases')
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
                    axios.post(`purchases`, payload)
                        .then((response) => {
                            resolve()
                        }).catch(error => {
                            console.log(error)
                            reject(error)
                        })
                } else {
                    axios.put(`purchases/${payload.id}`, payload)
                        .then((response) => {
                            resolve()
                        }).catch(error => {
                            console.log(error)
                            reject(error)
                        })
                }
            })
        }
    },

    getters: {
        getList(state: {list: IPurchase[]}) {
            return state.list
        }
    }
}
