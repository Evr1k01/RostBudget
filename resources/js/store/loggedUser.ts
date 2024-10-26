import axios from '../axios-instance.js'
import ILoginData from "../views/login/interfaces/ILoginData";
import {ActionContext} from "vuex";

export default {
    namespaced: true,

    state: {
        token: localStorage.getItem('accessToken') || null
    },

    mutations: {
        setAuthData(state: {token: string | null}, payload: string) {
            state.token = payload
        },

        destroyToken(state: {token: string | null}) {
            state.token = null
        }
    },

    actions: {
        login(context: ActionContext<any, any>, credentials: ILoginData): Promise<void> {
            return new Promise((resolve, reject) => {
                axios.post('login', credentials)
                    .then(response => {
                        const token = response.data.accessToken
                        localStorage.setItem('accessToken', token)

                        context.commit('setAuthData', token)
                        resolve()
                    }).catch(error => {
                    console.log(error)
                    reject(error)
                })
            })
        },

        logout(context: ActionContext<any, any>): void {
            if (context.getters.isLogged) {
                axios.post('logout').then(() => {
                    localStorage.removeItem('accessToken')
                    context.commit('destroyToken')
                }).catch(error => {
                    console.log(error)
                })
            }
        }
    },

    getters: {
        token(state: {token: string | null}) {
            return state.token
        },

        isLogged(state: {token: string | null}) {
            return state.token !== null
        }
    }
}
