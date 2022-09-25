export const everyAsync = async (arr, callback) => {
    for (let idx = 0; idx < arr.length; idx++) {
        if (!(await callback(arr[idx], idx, arr))) return false;
    }
    return true;
};
export const someAsync = async (arr, callback, thisArg = arr) => {
    for (let idx = 0; idx < arr.length; idx++) {
        if (await callback.call(thisArg, arr[idx], idx, arr)) return true;
    }
    return false;
};
