import {defineStore} from "pinia";
import {Property, PropertyVariation} from "./interfaces";
import {elements} from "chart.js";
import axios from "axios";

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
            this.properties = properties.sort((a,b) => a.name.toLowerCase() < b.name.toLowerCase() ? -1 : 1);
            this.stagingProperty = emptyProperty;
        },
        addProperty(property: Property) {
            this.properties.push(property)
            this.properties = this.properties.sort((a,b) => a.name.toLowerCase() < b.name.toLowerCase() ? -1 : 1);
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
        refreshProperties() {
            axios.get('/properties').then(({data}) => {
                this.properties = data.data;
            }).catch((error) => {
                console.log('Error! Could not reach the API. ' + error)
            })
        },
        updateProperty(property: Property) {
            this.properties = this.properties.map(acc => acc.id === property.id ? property : acc)
        }
    }
})
