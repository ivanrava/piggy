interface Account {
    id: bigint;
    icon: string;
    name: string;
    type: string;
    balance: string;
    last_update: string;
    color: string;
}

interface Category {
    id: number;
    icon: string;
    type: string;
    name: string;
    children: Array<Category>
}

interface Beneficiary {
    name: string;
    img: string;
    created_at: string;
}

export {
    Account, Category, Beneficiary
}
