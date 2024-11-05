<template>
    <v-col cols="12" class="text-center">
        <v-icon icon="mdi-cat" size="48px"></v-icon>
        <p>У вас нет расходов за {{currentMonth}}</p>
    </v-col>
</template>

<script lang="ts">
import {computed} from "vue";

export default {
    name: "EmptyComponent",

    setup(props, ctx) {
        const currentMonth = computed((): string => {
            const date = new Date()
            const monthName = date.toLocaleString('ru-RU', { month: 'long' });
            return `${monthName} ${date.getFullYear()}`
        })

        return {
            currentMonth
        }
    },
}
</script>

<style scoped>

</style>
