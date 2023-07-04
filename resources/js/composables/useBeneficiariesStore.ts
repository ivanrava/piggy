import {defineStore} from "pinia";
import {Beneficiary} from "./interfaces";

export const useBeneficiariesStore = defineStore('beneficiaries', {
    state: () => ({
        beneficiaries: []
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
        }
    }
})
