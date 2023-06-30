export function isColorDark(hex: String) {
    const brightness = Math.round(((parseInt(hex.slice(0,2), 16) * 299) +
        (parseInt(hex.slice(2,4), 16) * 587) +
        (parseInt(hex.slice(4,6), 16) * 114)) / 1000);

    return brightness > 148;
}
