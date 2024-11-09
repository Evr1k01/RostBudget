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
                    :model-value="expenses"
                    color="rgba(255, 255, 255, .7)"
                    height="200"
                    stroke-linecap="round"
                    :labels="expenses"
                    show-labels
                    smooth
                >
                </v-sparkline>
            </v-sheet>
        </v-card-text>
        <v-card-text>
            <div>
                Линия расходов за {{currentMonth}} в {{getCurrentCurrency}}
            </div>
        </v-card-text>

    </v-card>
</template>

<script lang="ts">
import {computed, onMounted, PropType, ref, toRef, watch} from "vue";
import IMonthOverview from "../../../interfaces/IMonthOverview";
import {useStore} from "vuex";
import IPurchase from "../../../interfaces/IPurchase";
import CurrencyEnum from "../../../utils/enums/CurrencyEnum";
import MonthEnum from "../../../utils/enums/MonthEnum";

export default {
    name: 'Analytic',
    props: {
        monthOverview: Object as PropType<IMonthOverview>
    },

    setup(props, ctx) {
        const store = useStore()
        const overview = toRef(props, 'monthOverview')
        const expenses = ref<number[]>([])

        const lastPurchases = computed((): IPurchase[] => store.getters['purchase/getLastPeriodList'])
        const currentCurrency = computed((): string => store.getters["currency/getCurrency"])

        const currentMonth = computed((): string => {
            return `${MonthEnum[overview.value.month].toLowerCase()} ${overview.value.year}`
        })

        const getCurrentCurrency = computed((): string => {
            return CurrencyEnum[currentCurrency.value]
        })

        watch(lastPurchases, (newValue) => {
            expenses.value = newValue.map((purchase: IPurchase) => {
                return parseFloat(Number(purchase.expense[currentCurrency.value]).toFixed(1))
            })
        })

        onMounted(() => {
            store.dispatch('purchase/getLastPeriodList', overview.value)
        })

        return {
            expenses,
            currentMonth,
            getCurrentCurrency
        }
    },
}
</script>

<style scoped>

</style>
