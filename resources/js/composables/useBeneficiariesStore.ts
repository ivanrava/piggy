import {defineStore} from "pinia";
import {Beneficiary} from "./interfaces";

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
        getBeneficiaries() {
            return this.beneficiaries.sort((a,b) => a.name < b.name ? -1 : 1);
        },
        setBeneficiaries(beneficiaries: Array<Beneficiary>) {
            this.beneficiaries = beneficiaries;
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
        }
    }
})
