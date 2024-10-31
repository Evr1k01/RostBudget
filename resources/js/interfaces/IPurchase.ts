import ICurrency from "./ICurrency";

interface IPurchase {
    id?: string,
    description: string,
    expense: ICurrency | string,
    date: string | object,
    categoryId: string
}

export default IPurchase
