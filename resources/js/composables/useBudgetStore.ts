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

export const useBudgetStore = defineStore('budget', {
    state: () => ({
        categories: [],
        year: new Date().getFullYear(),
        isLoading: true,
        stagingBudget: emptyBudget,
        stagingCategory: {}
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
            this.stagingBudget = JSON.parse(JSON.stringify(category))
        },
        refreshBudgets() {
            axios.get('/budget').then(({data}) => {
                this.budget = data.data;
            }).catch((error) => {
                console.log('Error! Could not reach the API. ' + error)
            })
        },
    }
})
