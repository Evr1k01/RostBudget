<template>
    <v-form ref="purchaseForm">
        <v-text-field
            v-model="editablePurchase.description"
            label="Описание"
            variant="solo"
            :rules="[requiredField]"
            required
            clearable
        ></v-text-field>

        <v-text-field
            v-model="editablePurchase.expense"
            :label="expenseLabel"
            variant="solo"
            :rules="[requiredField]"
            required
            clearable
        ></v-text-field>

        <v-date-input
            v-model="editablePurchase.date"
            variant="solo"
            label="Дата"
            prepend-icon=""
            first-day-of-week="1"
            cancel-text="Отмена"
            ok-text="Ок"
            :rules="[requiredField, dateRule]"
            required
            clearable
        ></v-date-input>

        <v-select
            v-model="editablePurchase.categoryId"
            label="Категория"
            variant="solo"
            :items="categories"
            :rules="[requiredField]"
            item-title="categoryName"
            item-value="id"
            hide-details
            required
        ></v-select>
    </v-form>
</template>

<script lang="ts">
import {computed, onMounted, PropType, ref, toRef} from "vue";
import {useStore} from "vuex";
import IPurchase from "../../../interfaces/IPurchase";
import CurrencyEnum from "../../../utils/enums/CurrencyEnum";
import ICategory from "../../../interfaces/ICategory";
import IFormValidation from "../../../interfaces/IFormValidation";
export default {
    name: "PurchaseForm",
    props: {
        purchase: Object as PropType<IPurchase>
    },

    setup(props, ctx) {
        const store = useStore()
        const purchaseForm = ref(null)

        const savedPurchase = toRef(props, 'purchase')
        const editablePurchase = ref<IPurchase>({
            description: '',
            expense: '',
            date: '',
            categoryId: ''
        })

        const categories = computed((): ICategory[] => store.getters["category/getList"])
        const currentCurrency = computed(() => store.getters["currency/getCurrency"])
        const expenseLabel = computed(() => `Расходы в ${CurrencyEnum[currentCurrency.value]}`)

        const requiredField = (value: string) => !!value || 'Данное поле обязательно'
        const dateRule = (value: string|undefined) => compareDate(value) || 'Указан неверный месяц!'

        const sendPurchaseData = async (): Promise<IPurchase> => {
            return new Promise((resolve, reject) => {
                purchaseForm.value?.validate()
                    .then((response: IFormValidation) => {
                        if (!response.valid) {
                            reject('Purchase validation failed')
                        }
                        const editedPurchase = Object.assign({}, editablePurchase.value, {
                            date: changeDateFormat(editablePurchase.value.date as Date)
                        } as IPurchase)
                        resolve(editedPurchase)
                    })
            })
        }

        const changeDateFormat = (date: Date): string => {
            const day = String(date.getDate()).padStart(2,'0')
            const month = String(date.getMonth()+1).padStart(2,'0')
            const year = date.getFullYear()
            return `${year}-${month}-${day}`
        }

        const compareDate = (date: string|undefined): boolean => {
            if (!date) {
                return false
            }

            // new date only for current month
            const currentDate = new Date(date)
            const startOfMonth = new Date();
            startOfMonth.setDate(1);
            startOfMonth.setHours(0, 0, 0, 0);

            const endOfMonth = new Date(startOfMonth);
            endOfMonth.setMonth(endOfMonth.getMonth() + 1);
            endOfMonth.setDate(0);
            endOfMonth.setHours(23, 59, 59, 999);
            return endOfMonth >= currentDate && startOfMonth <= currentDate
        }

        onMounted(() => {
            if (savedPurchase.value.id) {
                Object.assign(editablePurchase.value, savedPurchase.value, {
                    expense: savedPurchase.value.expense[currentCurrency.value],
                    date: new Date(savedPurchase.value.date as string)
                } as IPurchase)
            }
        })

        return {
            purchaseForm,
            editablePurchase,
            categories,
            expenseLabel,
            dateRule,
            requiredField,
            sendPurchaseData
        }
    },
}

</script>

<style scoped>

</style>
