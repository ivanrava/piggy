import {defineStore} from "pinia";
import {Category} from "./interfaces";
import axios from "axios";

const emptyCategory = {
    name: '',
    type: 'out',
    icon: '',
    parent_category_id: null,
    parent: {},
    budgetFields: {
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
}

export const useCategoriesStore = defineStore('categories', {
    state: () => ({
        categories: [],
        selectedCategory: null,
        stagingCategory: emptyCategory,
        isEditing: false,
        showForm: false
    }),
    actions: {
        selectCategory(category: Category) {
            if (category == null)
                this.selectedCategory = emptyCategory
            this.selectedCategory = category
            this.stagingCategory = emptyCategory
            this.isEditing = false
        },
        editCategory() {
            this.stagingCategory = JSON.parse(JSON.stringify(this.selectedCategory))
            this.isEditing = true
            this.showForm = true
        },
        refreshCategories() {
            axios.get('/categories/root').then(({data}) => {
                this.categories = data.data;
            }).catch((error) => {
                console.log('Error! Could not reach the API. ' + error)
            })
            this.stagingCategory = emptyCategory
        },
        deleteCategory(category: Category) {
            this.categories = this.categories.filter((cat: Category) => cat.id != category.id)
        },
        buildCategoryPayload() {
            return {
                name: this.stagingCategory.name,
                type: this.stagingCategory.type,
                icon: this.stagingCategory.icon,
                parent_category_id: this.stagingCategory.parent_category_id,
                parent: this.stagingCategory.parent,
                budget_overall: this.stagingCategory.budgetFields.budget_type === 'overall' ? this.stagingCategory.budgetFields.budget_overall : null,
                budget: this.stagingCategory.budgetFields.budget_type === 'fixed' ? {
                    jan: this.stagingCategory.budgetFields.budget_overall,
                    feb: this.stagingCategory.budgetFields.budget_overall,
                    mar: this.stagingCategory.budgetFields.budget_overall,
                    apr: this.stagingCategory.budgetFields.budget_overall,
                    may: this.stagingCategory.budgetFields.budget_overall,
                    jun: this.stagingCategory.budgetFields.budget_overall,
                    jul: this.stagingCategory.budgetFields.budget_overall,
                    aug: this.stagingCategory.budgetFields.budget_overall,
                    sep: this.stagingCategory.budgetFields.budget_overall,
                    oct: this.stagingCategory.budgetFields.budget_overall,
                    nov: this.stagingCategory.budgetFields.budget_overall,
                    dec: this.stagingCategory.budgetFields.budget_overall
                } : this.stagingCategory.budgetFields.budget
            }
        }
    }
})
