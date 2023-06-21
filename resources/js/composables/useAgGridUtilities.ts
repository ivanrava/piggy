const stringComparator = (valA, valB) => {
    if (valA.name == valB.name)
        return 0;
    return (valA.name > valB.name) ? 1 : -1;
}
const dateFormatter = (date) => {
    return (new Date(date.value)).toLocaleDateString(undefined, {weekday: 'short', year: 'numeric', month: 'short', day: 'numeric'})
}
const currencyFormatter = (curr) => {
    return curr.value.toString() + ' €'
}

export const useAgGridUtilites = () => {
    return { stringComparator, dateFormatter, currencyFormatter }
}
