import axios from '../axios-instance.js'
import ILoginData from "../views/login/interfaces/ILoginData";


export default {

    async login(loginData: ILoginData) {
        return axios.post('login', loginData)
            .then((response) => {
                const token = response.data.accessToken

                sessionStorage.setItem('accessToken', token)
            })
    },

    async logout() {
        return axios.post('logout').then(() => sessionStorage.removeItem('accessToken'))
    }
}
