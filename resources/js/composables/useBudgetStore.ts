import {defineStore} from "pinia";
import {Category} from "./interfaces";
import axios from "axios";

const emptyBudget = {
    budget_type: 'overall',
    budget_overall: 0,
    budget: {
        jan: 0,
        feb: 0,
        mar: 0,
        apr: 0,
        may: 0,
        jun: 0,
        jul: 0,
        aug: 0,
        sep: 0,
        oct: 0,
        nov: 0,
        dec: 0,
    }
}

const sumBudget = (budget) => {
    return budget.jan + budget.feb + budget.mar + budget.apr + budget.may + budget.jun +
        budget.jul + budget.aug + budget.sep + budget.oct + budget.nov + budget.dec
}

const isEmptyBudget = (category, forceNotEmpty: boolean) => {
    return forceNotEmpty && ((typeof category.budget === 'object' && sumBudget(category.budget) == 0) || category.budget == 0)
}

export const useBudgetStore = defineStore('budget', {
    state: () => ({
        categories: [],
        year: new Date().getFullYear(),
        isLoading: true,
        stagingCategory: {id:0},
        stagingBudget: emptyBudget,
        hideEmptyBudgets: true
    }),
    actions: {
        setYear(year: number|string) {
            this.year = year
            this.isLoading = true
            axios.get('/budget', {params:{year:year}}).then(({data}) => {
                this.categories = data.data;
            }).finally(() => {
                this.isLoading = false;
            })
        },
        editBudget(category: Category) {
            this.stagingCategory = JSON.parse(JSON.stringify(category))
            this.stagingBudget = JSON.parse(JSON.stringify(emptyBudget))
            if (typeof category.budget === 'object') {
                this.stagingBudget.budget_type = 'custom';
                this.stagingBudget.budget = JSON.parse(JSON.stringify(category.budget));
            } else {
                this.stagingBudget.budget_type = 'overall';
                this.stagingBudget.budget_overall = category.budget;
            }
        },
        refreshBudgets() {
            this.setYear(this.year)
        },
        buildCategoryPayload() {
            return {
                name: this.stagingCategory.name,
                type: this.stagingCategory.type,
                icon: this.stagingCategory.icon,
                parent_category_id: this.stagingCategory.parent_category_id,
                parent: this.stagingCategory.parent,
                budget_overall: this.stagingBudget.budget_type === 'overall' ? this.stagingBudget.budget_overall : null,
                budget: this.stagingBudget.budget_type === 'fixed' ? {
                    jan: this.stagingBudget.budget_overall,
                    feb: this.stagingBudget.budget_overall,
                    mar: this.stagingBudget.budget_overall,
                    apr: this.stagingBudget.budget_overall,
                    may: this.stagingBudget.budget_overall,
                    jun: this.stagingBudget.budget_overall,
                    jul: this.stagingBudget.budget_overall,
                    aug: this.stagingBudget.budget_overall,
                    sep: this.stagingBudget.budget_overall,
                    oct: this.stagingBudget.budget_overall,
                    nov: this.stagingBudget.budget_overall,
                    dec: this.stagingBudget.budget_overall
                } : this.stagingBudget.budget
            }
        },
        outCategories() {
            return this.categories.filter((cat: Category) => cat.type === 'out' && !isEmptyBudget(cat, this.hideEmptyBudgets))
        },
        inCategories() {
            return this.categories.filter((cat: Category) => cat.type === 'in' && !isEmptyBudget(cat, this.hideEmptyBudgets))
        }
    }
})
