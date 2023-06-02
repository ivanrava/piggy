interface Transaction {
    category: Category;
    beneficiary: Beneficiary;
    date: string;
    amount: string;
    notes: string;
}

interface Transfer {
    from_account_id: number;
    to_account_id: number;
    date: string;
    amount: string;
    notes: string;
}

interface Account {
    id: bigint;
    icon: string;
    name: string;
    type: string;
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
    children: Array<Category>
}

interface Beneficiary {
    id: string;
    name: string;
    img: string;
    created_at: string;
}

export {
    Account, Category, Beneficiary, Transaction, Transfer
}
