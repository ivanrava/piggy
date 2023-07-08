import {defineStore} from 'pinia'
import {Transaction, Transfer} from "./interfaces";
import useOperationHelpers from "./useOperationHelpers";

const defaultStagingTransaction = {
    id: 0,
    account_id: null,
    date: '',
    amount: 0,
    notes: '',
    beneficiary: {
        id: null,
        name: null,
        img: 'bottts'
    },
    category: {
        id: null,
        name: '',
        parent_category_id: null,
        icon: null
    }
}

const defaultStagingTransfer = {
    id: 0,
    account_id: null,
    amount: 0,
    isOut: true,
    notes: '',
    date: ''
}

export const useOperationsStore = defineStore('operations', {
    state: () => ({
        transactions: [],
        transfers: [],
        added: [],
        stagingTransaction: defaultStagingTransaction,
        stagingTransfer: defaultStagingTransfer,
        isEditing: false,
        isEditingTransfer: false,
        isShowForm: false,
    }),
    getters: {
        getOperations(state) {
            return state.transactions
                .concat(state.transfers)
                .concat(state.added)
        },
        getStagingOperation(state) {
            return state.isEditingTransfer ? state.stagingTransfer : state.stagingTransaction
        },
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
        updateOperation(operation) {
            const arrayName = this.isEditingTransfer ? 'transfers' : 'transactions';
            this[arrayName] = this[arrayName].map((op) => op.id === operation.id ? operation : op)
            this.added = this.added.map((op) => op.id === operation.id ? operation : op)

            this.isEditing = false;
        },
        setOperations(transactions, transfers_in, transfers_out) {
            this.closeForm(false);
            this.stagingTransaction = defaultStagingTransaction
            this.stagingTransfer = defaultStagingTransfer
            this.transactions = transactions
            this.transfers = transfers_in.concat(transfers_out)
            this.added = [];
        },
        showEdit(operation: Transfer|Transaction, isTransfer, currentAccountId) {
            if (isTransfer) {
                this.stagingTransaction = defaultStagingTransaction;
                const account = useOperationHelpers.getOtherAccount(<Transfer>operation, currentAccountId)
                const accountId = account.id
                this.stagingTransfer = JSON.parse(JSON.stringify({
                    ...operation,
                    account_id: accountId,
                    isOut: useOperationHelpers.isOutTransfer(<Transfer>operation, currentAccountId)
                }))
            } else {
                this.stagingTransaction = JSON.parse(JSON.stringify(operation))
                this.stagingTransfer = defaultStagingTransfer;
            }
            this.isEditing = true;
            this.isEditingTransfer = isTransfer;
            this.showForm();
        },
        changeOperationType(isTransfer) {
            this.isEditingTransfer = isTransfer
        },
        closeForm(moveToEditing) {
            this.isShowForm = false;
            this.isEditing = moveToEditing;
        },
        showForm() {
            this.isShowForm = true;
        },
        getTotal(currentAccountId = null) {
            return this.getOperations.reduce((acc, curr) => {
                if ('beneficiary' in curr) {
                    return curr.category.type == 'in' ? acc + Number(curr.amount) : acc - Number(curr.amount);
                } else {
                    return useOperationHelpers.isOutTransfer(curr, currentAccountId) ? acc - Number(curr.amount) : acc + Number(curr.amount);
                }
            }, 0)
        }
    }
})
