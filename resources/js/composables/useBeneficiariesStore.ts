import {defineStore} from "pinia";
import {Account, Beneficiary} from "./interfaces";

const emptyBeneficiary = {
    id: null,
    name: '',
    img: 'bottts'
}

export const useBeneficiariesStore = defineStore('beneficiaries', {
    state: () => ({
        beneficiaries: [],
        stagingBeneficiary: emptyBeneficiary,
        showForm: false,
        isEditing: false
    }),
    actions: {
        setBeneficiaries(beneficiaries: Array<Beneficiary>) {
            this.beneficiaries = beneficiaries.sort((a,b) => a.name < b.name ? -1 : 1);
        },
        addBeneficiary(beneficiary: Beneficiary) {
            this.beneficiaries.push(beneficiary)
        },
        editBeneficiary(beneficiary: Beneficiary) {
            this.stagingBeneficiary = JSON.parse(JSON.stringify(beneficiary))
            this.showForm = true
            this.isEditing = true
        },
        updateBeneficiary(beneficiary: Beneficiary) {
            this.beneficiaries = this.beneficiaries.map(ben => ben.id == beneficiary.id ? beneficiary : ben);
        },
        closeForm() {
            this.stagingBeneficiary = emptyBeneficiary
            this.showForm = false
            this.isEditing = false
        },
        deleteBeneficiary(beneficiary: Beneficiary) {
            this.beneficiaries = this.beneficiaries.filter(ben => ben.id != beneficiary.id)
        },
    }
})
