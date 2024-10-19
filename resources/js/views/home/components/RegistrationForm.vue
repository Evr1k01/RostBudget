<template>
    <v-form ref="registrationForm">
        <v-text-field
            v-model="registrationData.name"
            label="Ник/Имя"
            variant="outlined"
            :rules="[requiredRule]"
            clearable
            required
        ></v-text-field>
    </v-form>
</template>

<script lang="ts">
import {ref} from "vue";
import IFormValidation from "../../../interfaces/IFormValidation";

export default {
    name: "RegistrationForm",

    setup(props, ctx) {

        const registrationForm = ref(null)
        const registrationData = ref({
           name: ''
        })

        const requiredRule = (value: string) => !!value || 'Данное поле обязательно!'

        const sendRegistrationData = async () => {
            return new Promise((resolve, reject) => {
                registrationForm.value?.validate()
                    .then((response: IFormValidation) => {
                        if (!response.valid) {
                            reject('registration validation failed!')
                        }
                        resolve(registrationData.value)
                    })
            })
        }

        return {
            registrationForm,
            registrationData,
            requiredRule,
            sendRegistrationData
        }
    },
}

</script>

<style scoped>

</style>
