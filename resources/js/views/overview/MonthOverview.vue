<template>
    <v-container fluid>
        <v-data-table
            :items="monthOverviewList"
            :headers="headers as any"
            no-data-text="Информация отсутствует"
            items-per-page-text="Элементов на странице"
            :items-per-page-options="itemsPerPage"
            :show-current-page="true"
            page-text=""
            class="d-none d-sm-block"
        >
            <template v-slot:headers="{columns}">
                <tr>
                    <template v-for="column in columns" :key="column.key">
                        <th><span class="font-weight-bold">{{column.title}}</span></th>
                    </template>
                </tr>
            </template>
            <template v-slot:item.month="{item}">
                {{getFormattedDate(item)}}
            </template>

            <template v-slot:item.sum="{item}">
                {{getCurrentCurrency(item.sum)}}
            </template>

            <template v-slot:item.category="{item}">
                {{categoryById(item.category)}}
            </template>

            <template v-slot:item.analytic="{item}">
                <v-btn variant="text" color="#5865f2" class="px-2">Обзор</v-btn>
            </template>
        </v-data-table>

        <v-row class="d-block d-sm-none">
            <v-col cols="12" v-for="overview in monthOverviewList">
                <v-card
                    :key="overview.id"
                    class="home__card"
                >
                    <template v-slot:append>
                        <v-icon color="primary" :icon="categoryIcon(overview.category)" size="36px"></v-icon>
                    </template>

                    <template v-slot:title>
                        <v-row align="center" no-gutters>
                            <v-col class="d-flex align-center" cols="auto">
                                <v-icon icon="mdi-calendar" color="#5865f2" size="24px" class="me-1"></v-icon>
                            </v-col>
                            <v-col class="d-flex align-center" cols="auto">
                                <p class="font-weight-bold mb-0">{{ getFormattedDate(overview) }}</p>
                            </v-col>
                        </v-row>
                    </template>

                    <v-card-text>
                        <p class="home__card-description_text"><span class="home__card-span_text">Топ категория: </span>{{categoryById(overview.category)}}</p>
                        <p class="home__card-description_text"><span class="home__card-span_text">Расходы: </span>{{getCurrentCurrency(overview.sum)}}</p>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script lang="ts">
import {ref, computed, onMounted} from "vue";
import {useStore} from "vuex";
import IMonthOverview from "../../interfaces/IMonthOverview";
import CategoryNameEnum from "../../utils/enums/CategoryNameEnum";
import ICurrency from "../../interfaces/ICurrency";
import CurrencyEnum from "../../utils/enums/CurrencyEnum";
import MonthEnum from "../../utils/enums/MonthEnum";
import CategoryIconEnum from "../../utils/enums/CategoryIconEnum";

export default {
    name: "MonthOverview",

    setup(props, ctx) {
        const store = useStore()
        const monthOverviewList = computed((): IMonthOverview[] => store.getters['purchase/getMonthOverview'])
        const currentCurrency = computed((): string => store.getters['currency/getCurrency'])

        const headers = ref([
            { title: 'Период', align: 'start', key: 'month' },
            { title: 'Траты', align: 'start', key: 'sum' },
            { title: 'Топ категория', align: 'start', key: 'category' },
            { title: 'Аналитика', align: 'start', sortable: false, key: 'analytic' },
        ])

        const itemsPerPage = ref<{ title: string, value: number}[]>([
            {title: '12', value: 10},
            {title: '24', value: 20},
            {title: 'Все', value: -1}
        ])

        const categoryIcon = (icon: string) => {
            return CategoryIconEnum[icon]
        }

        const categoryById = (category: string): string => {
            return CategoryNameEnum[category]
        }

        const getCurrentCurrency = (expenses: ICurrency): string => {
            return `${expenses[currentCurrency.value]} ${CurrencyEnum[currentCurrency.value]}`
        }

        const getFormattedDate = (item: IMonthOverview): string => {
            return `${MonthEnum[item.month]} / ${item.year}`
        }

        onMounted(() => {
            store.dispatch('purchase/getMonthOverview')
        })

        return {
            monthOverviewList,
            headers,
            itemsPerPage,
            categoryIcon,
            categoryById,
            getCurrentCurrency,
            getFormattedDate
        }
    },
}

</script>

<style scoped>

</style>
