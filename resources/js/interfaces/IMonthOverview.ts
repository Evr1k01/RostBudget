import ICurrency from "./ICurrency";

interface IMonthOverview {
    id: string,
    sum: ICurrency,
    month: string,
    year: string,
    category: string
}

export default IMonthOverview
