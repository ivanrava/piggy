import {Transfer} from "./interfaces";

const getOtherAccount = (transfer: Transfer, currentAccountId: number) => {
    if ('to' in transfer && 'from' in transfer) {
        if (transfer.to.id == currentAccountId) {
            return transfer.from
        } else {
            return transfer.to
        }
    }
    return 'from' in transfer ? transfer.from : transfer.to;
}

const isOutTransfer = (transfer: Transfer, currentAccountId: number) => {
    if ('to' in transfer) {
        return transfer.to.id != currentAccountId;
    } else {
        return transfer.from.id == currentAccountId;
    }
}

export default {
    getOtherAccount, isOutTransfer
}
