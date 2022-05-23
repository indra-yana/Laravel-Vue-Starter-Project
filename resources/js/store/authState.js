import { defineStore } from 'pinia'
import SecureLS from "secure-ls";

const ls = new SecureLS({ isCompression: false });
const authState = defineStore('authState', {
    state: () => ({
        authData: {
            loggedIn: false,
            user: null,
        }
    }),
    getters: {
        isLoggedIn() {
            return this.authData.loggedIn;
        },
        auth() {
            return this.authData;
        },
    },
    actions:{
        loggedIn(user) {
            this.authData.loggedIn = true;
            this.authData.user = user;
        },
        logout() {
            this.$reset();
        },
    },
    persist: {
        key: 'auth-state',
        paths: ['authData'],
        storage: {
            getItem: (key) => ls.get(key),
            setItem: (key, value) => ls.set(key, value),
            removeItem: (key) => ls.remove(key)
        },
    },
});

export { authState };