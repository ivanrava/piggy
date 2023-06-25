import {defineStore} from "pinia";
import {Beneficiary} from "./interfaces";

export const useBeneficiariesStore = defineStore('beneficiaries', {
    state: () => ({
        beneficiaries: []
    }),
    actions: {
        setBeneficiaries(beneficiaries: Array<Beneficiary>) {
            this.beneficiaries = beneficiaries;
        },
        addBeneficiary(beneficiary: Beneficiary) {
            this.beneficiaries.push(beneficiary)
        }
    }
})
