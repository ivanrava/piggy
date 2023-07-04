import {defineStore} from "pinia";
import {Account} from "./interfaces";

const emptyAccount = {
    id: null,
    name: '',
    account_type_id: 1,
    initial_balance: 0,
    icon: '',
    color: '#ccc',
    opening: '',
    closing: '',
    description: ''
}

export const useAccountsStore = defineStore('accounts', {
    state: () => ({
        accounts: [],
        stagingAccount: emptyAccount,
        isEditing: false,
        showForm: false
    }),
    actions: {
        getAccounts() {
            return this.accounts.sort((a,b) => a.name < b.name ? -1 : 1);
        },
        setAccounts(accounts: Array<Account>) {
            this.accounts = accounts;
            this.stagingAccount = emptyAccount;
        },
        addAccount(account: Account) {
            this.accounts.push(account)
            this.isEditing = false
            this.showForm = false
        },
        editAccount(account: Account) {
            this.stagingAccount = JSON.parse(JSON.stringify(account))
            this.isEditing = true
            this.showForm = true
        },
        deleteAccount(account: Account) {
            this.accounts = this.accounts.filter(acc => acc.id != account.id)
        },
        emptyForm() {
            this.stagingAccount = emptyAccount;
        },
        updateAccount(account: Account) {
            this.accounts = this.accounts.map(acc => acc.id === account.id ? account : acc)
        }
    }
})
