import {defineStore} from "pinia";
import {Category} from "./interfaces";

export const useCategoriesStore = defineStore('categories', {
    state: () => ({
        selectedCategory: null
    }),
    actions: {
        selectCategory(category: Category) {
            this.selectedCategory = category;
        }
    }
})
