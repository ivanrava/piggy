import {defineStore} from 'pinia'

export const useOperationsStore = defineStore('operations', {
    state: () => ({
        transactions: [],
        transfers: [],
        added: [],
        stagingOperation: {
            id: 0,
            date: '',
            amount: 0,
            notes: '',
            beneficiary: {
                id: null
            },
            category: {
                id: null
            }
        },
        isEditing: false,
        isEditingTransfer: false,
        isShowForm: false
    }),
    getters: {
        getOperations(state) {
            return state.transactions.concat(state.transfers).concat(this.added)
        },
        getStagingOperation(state) {
            return state.stagingOperation
        },
        isEdit(state) {
            return state.stagingOperation.date !== ''
        },
        isFormShowed(state) {
            return state.isShowForm;
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
        updateOperation() {
            this.isEditing = false;
        },
        setOperations(transactions, transfers_in, transfers_out) {
            this.transactions = transactions
            this.transfers = transfers_in.concat(transfers_out)
            this.stagingOperation = {
                date: '',
                    amount: 0,
                    notes: '',
                    beneficiary: {
                    id: null
                },
                category: {
                    id: null
                }
            }
            this.closeForm();
            this.added = [];
        },
        showEdit(operation, isTransfer) {
            this.stagingOperation = operation;
            this.isEditing = true;
            this.isEditingTransfer = isTransfer;
            this.showForm();
        },
        closeForm() {
            this.isShowForm = false;
            this.isEditing = false;
        },
        showForm() {
            this.isShowForm = true;
        }
    }
})
