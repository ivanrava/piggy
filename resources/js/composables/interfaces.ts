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

interface Budget {
    jan: string;
    feb: string;
    mar: string;
    apr: string;
    may: string;
    jun: string;
    jul: string;
    aug: string;
    sep: string;
    oct: string;
    nov: string;
    dec: string;
}

interface Category {
    id: number;
    icon: string;
    type: string;
    name: string;
    parent_category_id: number;
    expenditures: Budget;
    budget: string|Budget;
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

interface PropertyVariation {
    id: number;
    property_id: number;
    type: string;
    notes: string;
    date: string;
    amount: string;
    value: number;
}

interface Property {
    id: number;
    name: string;
    icon: string;
    description: string;
    initial_value: string;
    value: string;
    variations: Array<PropertyVariation>;
}

export {
    Account, Category, Beneficiary, Transaction, Transfer, Property, PropertyVariation
}
