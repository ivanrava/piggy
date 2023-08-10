import {Category} from "./interfaces";

const budgetSum = (category: Category) => {
    if (category.budget_overall != null)
        return Number(category.budget_overall);
    else
        return Number(category.budget.jan) + Number(category.budget.feb) + Number(category.budget.mar) +
            Number(category.budget.apr) + Number(category.budget.may) + Number(category.budget.jun) +
            Number(category.budget.jul) + Number(category.budget.aug) + Number(category.budget.sep) +
            Number(category.budget.oct) + Number(category.budget.nov) + Number(category.budget.dec);
}
const offsetForChildCategory = (category: Category) => {
    return (useReportFunctions().budgetSum(category) - category.transactions_sum_amount) * (category.type == 'out' ? 1 : -1);
}
export const useReportFunctions = () => {
    return {budgetSum, offsetForChildCategory}
}
