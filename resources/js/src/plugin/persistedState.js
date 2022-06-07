import createPersistedState from "pinia-persistedstate";
import SecureLS from "secure-ls";

const ls = new SecureLS({ isCompression: false });
const persitedState = createPersistedState({
    key: 'app-data-store',
    paths: ['authState'],  // Keep state, use module id, or state
    storage: {
        getItem: (key) => ls.get(key),
        setItem: (key, value) => ls.set(key, value),
        removeItem: (key) => ls.remove(key)
    }
});

export default persitedState;