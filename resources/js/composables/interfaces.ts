interface Account {
    icon: string;
    name: string;
    type: string;
    balance: string;
    last_update: string;
    color: string;
}

interface Category {
    icon: string;
    type: string;
    name: string;
    children: Array<Category>
}

export {
    Account, Category
}
