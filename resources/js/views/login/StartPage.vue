<template>
    <v-container class="d-flex h-100 start-page__container" fluid>
        <v-row class="justify-center">
            <v-col cols="11" sm="8" md="4">
                <v-card>
                    <v-card-title>
                        {{ cardTitle }}
                    </v-card-title>
                    <v-card-text>
                        <registration-form v-if="accountCreation" ref="registrationForm"></registration-form>
                        <login-form ref="loginForm"></login-form>
                    </v-card-text>
                    <p class="text-center mt-n4"><a class="start-page__text-link" @click="choiceRegistrationOption">Забыли пароль?</a></p>
                    <v-card-actions>
                        <v-row justify="center">
                            <v-col col="12" sm="9" md="7">
                                <v-btn
                                    color="indigo-darken-3"
                                    class="start-page__button"
                                    variant="flat"
                                    @click="sendUserData"
                                    :loading="buttonLoading"
                                    rounded
                                    block
                                >
                                    {{ buttonTitle }}
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
                <p class="text-center ma-1">Нет аккаунта? <a class="start-page__text-link" @click="choiceRegistrationOption">{{ actionTitle }}</a></p>
            </v-col>
        </v-row>
    </v-container>
</template>

<script lang="ts">
import {computed, ref} from "vue";
import LoginForm from "./components/LoginForm.vue";
import RegistrationForm from "./components/RegistrationForm.vue";
import ILoginData from "./interfaces/ILoginData";
import {useRouter} from "vue-router";
export default {
    name: "StartPage",
    components: {
        LoginForm,
        RegistrationForm
    },

    setup(props, context) {

        const loginForm = ref(null)
        const registrationForm = ref(null)
        const router = useRouter()

        const accountCreation = ref<boolean>(false)

        const cardTitle = computed((): string => {
            return accountCreation.value ? 'Регистрация' : 'Вход в аккаунт'
        })

        const buttonTitle = computed((): string => {
            return accountCreation.value ? 'Продолжить' : 'Войти'
        })

        const actionTitle = computed((): string => {
            return accountCreation.value ? 'Войти в аккаунт' : 'Зарегестрироваться'
        })

        const buttonLoading = ref<boolean>(false)

        const triggerForms = async () => {
            const result = []

            if (loginForm.value) {
                result.push(loginForm.value.sendLoginData())
            }

            if (registrationForm.value) {
                result.push(registrationForm.value.sendRegistrationData())
            }

            return Promise.all(result)
        }

        const sendUserData = () => {
            triggerForms().then((response) => {
                console.log(response)
                router.push({name: 'Home'})
            })
        }

        const choiceRegistrationOption = () => {
            accountCreation.value =! accountCreation.value
        }

        return {
            loginForm,
            registrationForm,
            accountCreation,
            cardTitle,
            buttonTitle,
            actionTitle,
            buttonLoading,
            choiceRegistrationOption,
            sendUserData
        }
    }
}

</script>

<style scoped>

</style>
