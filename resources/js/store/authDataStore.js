import { defineStore } from 'pinia'

export const authDataStore = defineStore('authDataStore', {
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
        setLoggedIn(loggedIn) {
            this.authData.loggedIn = loggedIn;
        },
        setUser(user) {
            this.authData.user = user;

            // this.user.name = user.name;
            // this.user.username = user.username;
            // this.user.email = user.email;
        },
    }
});