import {defineStore} from "pinia";
import {Property} from "./interfaces";
import {elements} from "chart.js";

const emptyProperty = {
    id: null,
    name: '',
    initial_value: 0,
    icon: '',
    description: ''
}

export const usePropertyStore = defineStore('properties', {
    state: () => ({
        properties: [],
        stagingProperty: emptyProperty,
        isEditing: false,
        showForm: false
    }),
    actions: {
        setProperties(properties: Array<Property>) {
            this.properties = properties.sort((a,b) => a.name < b.name ? -1 : 1);
            this.stagingProperty = emptyProperty;
        },
        addProperty(property: Property) {
            this.properties.push(property)
            this.properties = this.properties.sort((a,b) => a.name < b.name ? -1 : 1);
            this.isEditing = false
            this.showForm = false
        },
        editProperty(property: Property) {
            this.stagingProperty = JSON.parse(JSON.stringify(property))
            this.isEditing = true
            this.showForm = true
        },
        deleteProperty(property: Property) {
            this.properties = this.properties.filter(acc => acc.id != property.id)
        },
        emptyForm() {
            this.stagingProperty = emptyProperty;
        },
        updateProperty(property: Property) {
            this.properties = this.properties.map(acc => acc.id === property.id ? property : acc)
        }
    }
})
