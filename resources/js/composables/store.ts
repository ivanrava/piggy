import {defineStore} from 'pinia'

export const useOperationsStore = defineStore('operations', {
    state: () => ({
        transactions: [],
        transfers: [],
        added: []
    }),
    getters: {
        getOperations(state) {
            return state.transactions.concat(state.transfers).concat(this.added)
        }
    },
    actions: {
        deleteOperation(id, isTransfer) {
            const arrayName = isTransfer ? 'transfers' : 'transactions';
            this[arrayName] = this[arrayName].filter((operation) => operation.id !== id)
            this.added = this.added.filter((operation) => operation.id !== id)
        },
        addOperation(operation) {
            this.added.push(operation)
        },
        setOperations(transactions, transfers_in, transfers_out) {
            this.transactions = transactions
            this.transfers = transfers_in.concat(transfers_out)
            this.added = [];
        },
    }
})
