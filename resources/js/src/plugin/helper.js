const toIDR = (price, decimal = 0) => { 
    price = parseInt(price || 0);
    return 'Rp' + Number(price.toFixed(decimal)).toLocaleString().replace(/\./g, "@").replace(/,/g, ".").replace(/@/g, ","); 
 }
 
const splitLongText = (text, split = 20, length = 15) => { 
    return text.length > length ? text.substring(0, split) + '...' : text;
}

// TODO: Hotfix these value are empty
const baseURL = `${process.env.MIX_APP_BASE_URL}`;
const apiURL = `${process.env.MIX_APP_BASE_URL}/api`;

export {
    toIDR,
    splitLongText,
    baseURL,
    apiURL,
};