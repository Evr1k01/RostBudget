import ICurrency from "./ICurrency";

interface IPurchase {
    id: string,
    description: string,
    expense: ICurrency,
    date: string,
    categoryId: string
}

export default IPurchase
