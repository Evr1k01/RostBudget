import axios$ from '../axios-instance.js'
import {ActionContext} from "vuex";
import IPurchase from "../interfaces/IPurchase";
import IMonthOverview from "../interfaces/IMonthOverview";
import ICurrency from "../interfaces/ICurrency";

interface PurchaseState {
    list: IPurchase[],
    monthOverview: IMonthOverview[],
    monthExpenses: ICurrency
}

export default {
    namespaced: true,

    state: {
        list: [],
        monthOverview: [],
        monthExpenses: []
    },

    mutations: {
        listSuccess(state: PurchaseState, payload: IPurchase[]) {
            state.list = payload
        },

        createSuccess(state: PurchaseState, payload: IPurchase[]) {
            state.list = payload
        },

        updateSuccess(state: PurchaseState, payload: IPurchase[]) {
            state.list = payload
        },

        deleteSuccess(state: PurchaseState, payload: string) {
            let entityIndex = state.list.findIndex((item) => item.id === payload)
            if (entityIndex > -1) {
                state.list.splice(entityIndex, 1)
            }
        },

        monthOverviewSuccess(state: PurchaseState, payload: IMonthOverview[]) {
            state.monthOverview = payload
        },

        monthExpensesSuccess(state: PurchaseState, payload: ICurrency) {
            state.monthExpenses = payload
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
        },

        async getMonthOverview(context: ActionContext<any, any>): Promise<void> {
            return new Promise((resolve, reject) => {
                axios$.get('month-overview')
                    .then(response => {
                        context.commit('monthOverviewSuccess', response.data.data)
                        resolve()
                    }).catch(error => {
                    reject(error)
                })
            })
        },

        async getMonthExpenses(context: ActionContext<any, any>): Promise<void> {
            return new Promise((resolve, reject) => {
                axios$.get('month-expenses')
                    .then(response => {
                        context.commit('monthExpensesSuccess', response.data)
                        resolve()
                    }).catch(error => {
                    reject(error)
                })
            })
        },
    },

    getters: {
        getList(state: PurchaseState) {
            return state.list
        },

        getMonthOverview(state: PurchaseState){
            return state.monthOverview
        },

        getMonthExpenses(state: PurchaseState){
            return state.monthExpenses
        }
    }
}
