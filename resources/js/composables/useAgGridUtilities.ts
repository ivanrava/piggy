const currencyFormatterBare = (curr) => {
    return curr.toLocaleString(undefined, { minimumFractionDigits: 2 }) + ' €'
}

const stringComparator = (valA, valB) => {
    if (valA.name == valB.name)
        return 0;
    return (valA.name > valB.name) ? 1 : -1;
}
const dateFormatter = (date) => {
    if (window.innerWidth <= 480) {
        return (new Date(date.value)).toLocaleDateString(undefined, {year: 'numeric', month: 'numeric', day: 'numeric'})
    }

    return (new Date(date.value)).toLocaleDateString(undefined, {weekday: 'short', year: 'numeric', month: 'short', day: 'numeric'})
}
const currencyFormatter = (curr) => {
    return currencyFormatterBare(curr.value)
}

export const useAgGridUtilites = () => {
    return { stringComparator, dateFormatter, currencyFormatter, currencyFormatterBare }
}
