<template>
    <v-card
        class="mx-auto text-center my-5"
        max-width="600"
        color="#5865f2"
        dark
    >
        <v-card-text>
            <v-sheet color="rgba(0, 0, 0, .12)">
                <v-sparkline
                    :model-value="[400,300,200,500,799]"
                    color="rgba(255, 255, 255, .7)"
                    height="200"
                    padding="10"
                    stroke-linecap="round"
                    :labels="[400,300,200,500,799]"
                    show-labels
                    smooth
                >
                </v-sparkline>
            </v-sheet>
        </v-card-text>
        <v-card-text>
            <div>
                Расходы за {{currentMonth}}
            </div>
        </v-card-text>

    </v-card>
</template>

<script lang="ts">

import {computed} from "vue";

export default {
    name: "Sparkline",

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
