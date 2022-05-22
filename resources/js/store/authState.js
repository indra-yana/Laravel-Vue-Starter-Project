import { defineStore } from 'pinia'

const authState = defineStore('authState', {
    state: () => ({
        authData: {
            loggedIn: false,
            user: {},
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
            this.authData.loggedIn = false;
            this.authData.user = {};
        },
    }
});

export { authState };