import {defineStore} from "pinia";
import {Category} from "./interfaces";
import axios from "axios";

const emptyCategory = {
    name: '',
    type: 'out',
    icon: '',
    parent_category_id: null
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
        }
    }
})
