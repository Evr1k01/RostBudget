<template>
    <v-dialog max-width="500px" v-model="dialog">
        <v-card>
            <v-card-title>Удаление</v-card-title>
            <v-card-text>Вы действительно хотите удалить данную запись?</v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-btn color="blue" variant="tonal" @click="closeDelete">
                    Отмена
                </v-btn>
                <v-btn color="red" variant="tonal" @click="deletePurchaseConfirm">
                    Удалить
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script lang="ts">
import {toRef} from "vue";

export default {
    name: "DeletionDialog",
    props: {
        deletionDialog: Boolean
    },
    emits: ['deletePurchase', 'closeDelete'],

    setup(props, ctx) {
        const dialog = toRef(props, 'deletionDialog')

        const deletePurchaseConfirm = () => {
            ctx.emit('deletePurchase')
        }

        const closeDelete = () => {
            ctx.emit('closeDelete')
        }

        return {
            dialog,
            deletePurchaseConfirm,
            closeDelete
        }
    },
}
</script>

<style scoped>

</style>
