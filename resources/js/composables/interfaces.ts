interface Transaction {
    id: number;
    category: Category;
    beneficiary: Beneficiary;
    date: string;
    amount: string;
    notes: string;
}

interface Transfer {
    id: number;
    from_account_id: number;
    to_account_id: number;
    to: Account;
    from: Account;
    date: string;
    amount: string;
    notes: string;
}

interface Account {
    id: number;
    icon: string;
    name: string;
    type: string;
    initial_balance: string;
    balance: string;
    last_update: string;
    color: string;
    opening: string;
    closing: string;
    description: string;
    transactions: Array<Transaction>;
    in_transfers: Array<Transfer>;
    out_transfers: Array<Transfer>;
}

interface Category {
    id: number;
    icon: string;
    type: string;
    name: string;
    parent_category_id: number;
    children: Array<Category>;
    transactions: Array<Transaction>;
}

interface Beneficiary {
    id: number;
    name: string;
    img: string;
    created_at: string;
    transactions: Array<Transaction>;
}

export {
    Account, Category, Beneficiary, Transaction, Transfer
}
