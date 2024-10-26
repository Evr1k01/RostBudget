<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12" class="text-end">
                <v-btn variant="tonal" :width="buttonWidth">Добавить</v-btn>
            </v-col>
            <v-divider></v-divider>
            <v-col cols="12" sm="6" md="4" xxl="3" v-for="purchase in purchasesList">
                <v-card
                    :key="purchase.id"
                >
                    <template v-slot:append>
                        <v-icon color="primary" :icon="categoryIcon(purchase.categoryId)" size="36px"></v-icon>
                    </template>

                    <template v-slot:title>
                        <v-row align="center" no-gutters>
                            <v-col class="d-flex align-center" cols="auto">
                                <v-icon icon="mdi-calendar" color="#5865f2" size="24px" class="me-1"></v-icon>
                            </v-col>
                            <v-col class="d-flex align-center" cols="auto">
                                <p class="font-weight-bold mb-0">{{ dateFormat(purchase.date, 'day') }} {{getDayOfWeek(purchase.date)}}</p>
                            </v-col>
                        </v-row>
                    </template>

                    <template v-slot:subtitle>
                        <p>{{dateFormat(purchase.date, 'month')}}</p>
                    </template>

                    <v-card-text>
                        <p class="home__card-description_text"><span class="home__card-span_text">Категория: </span>{{categoryName(purchase.categoryId)}}</p>
                        <p class="home__card-description_text"><span class="home__card-span_text">Описание: </span>{{purchase.description}}</p>
                        <p class="home__card-description_text"><span class="home__card-span_text">Расходы: </span>{{setCurrentCurrency(purchase.expense)}}</p>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn
                            variant="plain"
                            color="primary"
                            density="compact"
                            icon="mdi-pencil"
                        ></v-btn>

                        <v-btn
                            variant="plain"
                            color="red"
                            density="compact"
                            icon="mdi-delete-forever"
                        ></v-btn>
                    </v-card-actions>
                </v-card>

            </v-col>
        </v-row>
    </v-container>
</template>

<script lang="ts">
import {computed, ref, onMounted} from "vue"
import {useStore} from "vuex";
import IPurchase from "../../interfaces/IPurchase";
import CategoryNameEnum from "../../utils/enums/CategoryNameEnum";
import CategoryIconEnum from "../../utils/enums/CategoryIconEnum";
import DayOfTheWeekEnum from "../../utils/enums/DayOfTheWeekEnum";
import {useDisplay} from "vuetify";
import ICurrency from "../../interfaces/ICurrency";
import CurrencyEnum from "../../utils/enums/CurrencyEnum";
export default {
    name: "Home",

    setup(props, ctx) {
        const store = useStore()
        const display = useDisplay()

        const purchasesList = computed((): IPurchase[] => store.getters["purchase/getList"])
        const currentCurrency = computed((): string => store.getters["currency/getCurrency"])

        const buttonWidth = computed((): string => display.smAndDown.value ? '100%' : '15%')

        const categoryName = (id: string) => {
            return CategoryNameEnum[id]
        }

        const categoryIcon = (icon: string) => {
            return CategoryIconEnum[icon]
        }

        const dateFormat = (savedDate: string, type: 'day' | 'month'): string => {
            const formattedDate = new Date(savedDate)
            return type === 'day'
                ? String(formattedDate.getDate()).padStart(2,'0')
                : String(formattedDate.getMonth() + 1).padStart(2,'0')+'.'+formattedDate.getFullYear()
        }

        const getDayOfWeek = (savedDate: string): string => {
            const formattedDate = new Date(savedDate)
            const dayOfTheWeek = formattedDate.toDateString().split(' ', 1)
            return DayOfTheWeekEnum[dayOfTheWeek[0]]
        }

        const setCurrentCurrency = (expenses: ICurrency) => {
            return `${expenses[currentCurrency.value]} ${CurrencyEnum[currentCurrency.value]}`
        }

        onMounted(() => {
            store.dispatch('purchase/getList')
        })

        return {
            purchasesList,
            buttonWidth,
            categoryName,
            categoryIcon,
            dateFormat,
            getDayOfWeek,
            setCurrentCurrency
        }
    },
}
</script>


<style scoped>

</style>
