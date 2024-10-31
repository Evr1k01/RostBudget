import axios$ from '../axios-instance.js'
import ICategory from "../interfaces/ICategory";
import {ActionContext} from "vuex";
export default {
    namespaced: true,

    state: {
        list: []
    },

    mutations: {
        listSuccess(state: {list: ICategory[]}, payload: ICategory[]) {
            state.list = payload
        }
    },

    actions: {
        async getList(context: ActionContext<any, any>): Promise<void> {
            return new Promise((resolve, reject) => {
                axios$.get('categories')
                    .then(response => {
                        context.commit('listSuccess', response.data.data)
                        resolve()
                    }).catch(error => {
                        console.log(error)
                        reject(error)
                    })
            })
        }
    },

    getters: {
       getList(state: {list: ICategory[]}) {
           return state.list
       }
    }
}
