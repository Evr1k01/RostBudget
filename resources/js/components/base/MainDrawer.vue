<template>
    <v-navigation-drawer
        :location="drawerLocation"
        v-model="drawer"
    >
        <v-list>
            <v-list-item
                v-for="item in drawerItems"
                :title="item.title"
                :to="item.to"
            >
                <template v-slot:prepend>
                    <v-icon
                        :icon="item.icon"
                        color="#5865f2"
                    ></v-icon>
                </template>
            </v-list-item>
        </v-list>
        <v-divider></v-divider>
        <v-select
            v-model="currentCurrency"
            label="Валюта"
            :items="currencies"
            item-title="currencyCode"
            item-value="id"
            @update:modelValue="setCurrentCurrency"
            no-data-text="Валюты отсутствуют"
        >
        </v-select>
    </v-navigation-drawer>
</template>

<script lang="ts">
import {useDisplay} from "vuetify";
import {computed, onMounted, ref, watch} from "vue";
import {useStore} from "vuex";

export default {
    name: "MainDrawer",

    setup(props, ctx) {
        const store = useStore()
        const display = useDisplay()

        const drawer = computed((): boolean => store.getters['system/getDrawer'])
        const drawerLocation = computed(() => display.mobile.value ? 'bottom' : 'start')
        const drawerItems = ref([
            {
                icon: 'mdi-calendar-check',
                title: 'Актуальный месяц',
                to: 'home'
            },

            {
                icon: 'mdi-calendar-search',
                title: 'Месячный обзор',
                to: 'months-review'
            },

            {
                icon: 'mdi-note-search-outline',
                title: 'Текущая аналитика',
                to: 'analytic'
            }
        ])

        const currencies = computed(() => store.getters['currency/getList'])
        const currency = computed(() => store.getters['currency/getCurrency'])
        const currentCurrency = ref<string>(currency.value)

        const setCurrentCurrency = (currency: string) => {
            store.dispatch('currency/setCurrency', {currencyId: currency})
        }

        watch(currency, (updatedCurrency) => {
            currentCurrency.value = updatedCurrency
        })

        onMounted(() => {
            store.dispatch('currency/getList')
            store.dispatch('currency/getCurrency')
        })

        return {
            drawer,
            drawerLocation,
            drawerItems,
            currencies,
            currentCurrency,
            setCurrentCurrency
        }
    },
}
</script>


<style scoped>

</style>
