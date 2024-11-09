<template>
    <v-col cols="12" class="text-center">
        <v-icon icon="mdi-cat" size="48px"></v-icon>
        <p>{{currentMonth}}</p>
    </v-col>
</template>

<script lang="ts">
import {computed, PropType, Ref, toRef} from "vue";

export default {
    name: "EmptyComponent",
    props: {
        page: String as PropType<'Home' | 'Overview'>
    },

    setup(props, ctx) {
        const page = toRef(props, 'page') as Ref<'Home' | 'Overview'>

        const currentMonth = computed((): string => {
            const date = new Date()
            const monthName = date.toLocaleString('ru-RU', { month: 'long' });
            return page.value === 'Home'
                ? `У вас нет расходов за  ${monthName} ${date.getFullYear()}`
                : 'У вас нет истории прошлых месяцев'
        })

        return {
            currentMonth
        }
    },
}
</script>

<style scoped>

</style>
