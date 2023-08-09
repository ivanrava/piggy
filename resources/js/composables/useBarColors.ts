const barBgColor = (percentage: number, isOut: boolean) => {
    if (isOut)
        return {
            'dark:bg-red-400/60 bg-red-500/50': percentage < 100,
            'dark:bg-red-800/90 bg-red-700/80': percentage == 100
        };
    else
        return {
            'dark:bg-green-400/60 bg-green-500/50': percentage < 100,
            'dark:bg-green-800/90 bg-green-700/80': percentage == 100
        };
}
const barTextColor = (percentage: number, isOut: boolean) => {
    if (isOut)
        return {
            'dark:text-red-50': percentage == 0,
            'dark:text-red-400/80 text-red-800/80': percentage < 100 && percentage > 0,
            'dark:text-red-600 text-red-800/90 font-bold': percentage == 100
        }
    else
        return {
            'dark:text-green-50': percentage == 0,
            'dark:text-green-400/80 text-green-800/80': percentage < 100 && percentage > 0,
            'dark:text-green-600 text-green-800/90 font-bold': percentage == 100
        }
}

const barBg = 'dark:bg-stone-950/40 bg-stone-300'

export const useBarColors = () => {
    return {barBgColor, barTextColor, barBg}
}
