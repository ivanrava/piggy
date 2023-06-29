import {defineStore} from "pinia";
import {Account} from "./interfaces";

export const useAccountsStore = defineStore('accounts', {
    state: () => ({
        accounts: []
    }),
    actions: {
        setAccounts(accounts: Array<Account>) {
            this.accounts = accounts;
        },
        addAccount(account: Account) {
            this.accounts.push(account)
        }
    }
})
