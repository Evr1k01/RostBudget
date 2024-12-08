<template>
    <v-container fluid>
        <v-row>
            <v-col cols="12">
                <v-row justify="center" class="align-sm-center">
                    <v-col cols="12" sm="6" class="text-sm-start text-center home__header-expense_text">
                        <p>
                            <span class="home__header-expense_number">
                                <v-icon size="24px" class="pb-2">mdi-cash-multiple</v-icon> -{{setCurrentCurrency(monthExpenses)}}
                            </span>
                        </p>
                    </v-col>
                    <v-col cols="12" sm="6" class="text-sm-end text-center">
                        <v-btn variant="tonal" :width="buttonWidth" @click="editPurchase">Добавить</v-btn>
                    </v-col>
                </v-row>
            </v-col>
            <v-divider></v-divider>
            <v-col cols="12" sm="6" md="4" xxl="3" v-if="purchasesList.length > 0" v-for="purchase in purchasesList">
                <v-card
                    :key="purchase.id"
                    class="home__card"
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
                                <p class="font-weight-bold mb-0">{{ dateFormat(purchase.date as string, 'day') }} {{getDayOfWeek(purchase.date as string)}}</p>
                            </v-col>
                        </v-row>
                    </template>

                    <template v-slot:subtitle>
                        <p>{{dateFormat(purchase.date as string, 'month')}}</p>
                    </template>

                    <v-card-text>
                        <p class="home__card-description_text"><span class="home__card-span_text">Категория: </span>{{categoryName(purchase.categoryId)}}</p>
                        <p class="home__card-description_text"><span class="home__card-span_text">Описание: </span>{{purchase.description}}</p>
                        <p class="home__card-description_text"><span class="home__card-span_text">Расходы: </span>{{setCurrentCurrency(purchase.expense as ICurrency)}}</p>
                    </v-card-text>
                    <v-card-actions class="justify-end home__card-fixed_actions">
                        <v-btn
                            variant="plain"
                            color="primary"
                            density="compact"
                            icon="mdi-pencil"
                            @click="editPurchase(purchase)"
                        ></v-btn>

                        <v-btn
                            variant="plain"
                            color="red"
                            density="compact"
                            icon="mdi-delete-forever"
                            @click="deletePurchase(purchase)"
                        ></v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <empty-component v-else :page="'Home'"></empty-component>
        </v-row>

        <v-dialog v-model="purchaseActions.edit" max-width="500px">
            <v-card>
                <v-card-text>{{ editDialogTitle }}</v-card-text>
                <v-card-text>
                    <purchase-form ref="purchaseForm" :purchase="purchase"></purchase-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="blue" variant="tonal" @click="closePurchaseEdit">
                        Отмена
                    </v-btn>
                    <v-btn color="success" variant="tonal" @click="savePurchase">
                        Сохранить
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <deletion-dialog
            :deletion-dialog="purchaseActions.delete"
            @deletePurchase="purchaseDeletionConfirm"
            @closeDelete="closePurchaseDelete"
        ></deletion-dialog>

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
import PurchaseForm from "./components/PurchaseForm.vue";
import EmptyComponent from "./components/EmptyComponent.vue";
import DeletionDialog from "./components/DeletionDialog.vue";
export default {
    name: "Home",
    components: {
        PurchaseForm,
        EmptyComponent,
        DeletionDialog
    },

    setup(props, ctx) {
        const store = useStore()
        const display = useDisplay()
        const loading = ref<boolean>(false)

        const purchase = ref({} as IPurchase)
        const clearPurchase = ref({
            id: null,
            description: '',
            expense: '',
            date: '',
            categoryId: ''
        } as IPurchase)

        const purchasesList = computed((): IPurchase[] => store.getters["purchase/getList"])
        const monthExpenses = computed((): ICurrency => store.getters["purchase/getMonthExpenses"])
        const currentCurrency = computed((): string => store.getters["currency/getCurrency"])

        const buttonWidth = computed((): string => display.smAndDown.value ? '100%' : '30%')
        const purchaseActions = ref({
            edit: false,
            delete: false
        })
        const purchaseForm = ref(null)

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
            return `${Number(expenses[currentCurrency.value]).toFixed(1)} ${CurrencyEnum[currentCurrency.value]}`
        }

        const editDialogTitle = computed(() => purchase.value.id ? 'Редактирование' : 'Добавление')

        const editPurchase = (savedPurchase: IPurchase | null = null) => {
            if (savedPurchase) {
                Object.assign(purchase.value, savedPurchase)
            }

            purchaseActions.value.edit = true
        }

        const savePurchase = () => {
            if (purchaseForm.value) {
                loading.value = true
                purchaseForm.value.sendPurchaseData()
                    .then(async (response: IPurchase) => {
                        await store.dispatch('purchase/storePurchase', response)
                        await store.dispatch('purchase/getMonthExpenses')
                        purchaseActions.value.edit = false
                    }).finally(() => loading.value = false)
            }
        }

        const closePurchaseEdit = () => {
            purchaseActions.value.edit = false
            setTimeout(() => {
                Object.assign(purchase.value, clearPurchase.value)
            }, 200)
        }

        const deletePurchase = (item: IPurchase) => {
            Object.assign(purchase.value, item)
            purchaseActions.value.delete = true
        }

        const purchaseDeletionConfirm = () => {
            store.dispatch('purchase/deletePurchase', purchase.value)
                .then(() => {
                    store.dispatch('purchase/getMonthExpenses')
                    closePurchaseDelete()
                })
        }

        const closePurchaseDelete = () => {
            Object.assign(purchase.value, clearPurchase.value)
            purchaseActions.value.delete = false
        }

        onMounted(() => {
            store.dispatch('purchase/getList')
            store.dispatch('purchase/getMonthExpenses')
            store.dispatch('category/getList')
        })

        return {
            purchasesList,
            purchaseForm,
            buttonWidth,
            purchaseActions,
            purchase,
            monthExpenses,
            editDialogTitle,
            categoryName,
            categoryIcon,
            dateFormat,
            getDayOfWeek,
            setCurrentCurrency,
            editPurchase,
            savePurchase,
            closePurchaseEdit,
            deletePurchase,
            purchaseDeletionConfirm,
            closePurchaseDelete
        }
    },
}
</script>


<style scoped>

</style>
