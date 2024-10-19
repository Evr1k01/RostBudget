<template>
    <v-form ref="loginForm">
        <v-text-field
            v-model="loginData.email"
            label="Email"
            variant="outlined"
            :rules="[requiredRule, emailRule]"
            required
            clearable
        >
        </v-text-field>

        <v-text-field
            v-model="loginData.password"
            label="Пароль"
            variant="outlined"
            :rules="[requiredRule]"
            required
            clearable
        >
        </v-text-field>
    </v-form>
</template>

<script lang="ts">
import {ref} from "vue";
import IFormValidation from "../../../interfaces/IFormValidation";
import ILoginData from "../interfaces/ILoginData";

export default {
    name: "LoginForm",
    emits: [],

    setup(props, ctx) {
        const loginForm = ref(null)
        const loginData = ref<ILoginData>({
            email: '',
            password: ''
        })

        const requiredRule = (value: string) => !!value || 'Данное поле обязательно!'
        const emailRule = (value: string) => /.+@.+\..+/.test(value) || 'Укажите правильный формат E-mail'

        const sendLoginData = async (): Promise<ILoginData> => {
            return new Promise((resolve, reject) => {
                loginForm.value?.validate()
                    .then((response: IFormValidation) => {
                        if (!response.valid) {
                            reject('login validation failed!')
                        }
                        resolve(loginData.value)
                })
            })
        }

        return {
            loginData,
            loginForm,
            emailRule,
            requiredRule,
            sendLoginData
        }
    },
}

</script>

<style scoped>

</style>
