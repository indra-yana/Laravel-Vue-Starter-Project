import { defineStore } from 'pinia'
import SecureLS from "secure-ls";
import { postState } from '@src/store/postState.js';
import { socialLinkState } from '@src/store/socialLinkState.js';

const ls = new SecureLS({ isCompression: false });
const authState = defineStore('authState', {
    state: () => ({
        authData: {
            loggedIn: false,
            hasVerifiedEmail: false,
            user: null,
        },
        session: {
            active: false,
            message: "", 
        },
    }),
    getters: {
        isLoggedIn() {
            return this.authData.loggedIn;
        },
        auth() {
            return this.authData;
        },
        isSessionExpired() {
            return !this.session.active;
        }
    },
    actions:{
        loggedIn(user) {
            this.authData.loggedIn = true;
            this.authData.hasVerifiedEmail = user.email_verified_at != null ? true : false;
            this.authData.user = user;

            this.session.active = true;
            this.session.message = "Session is currently active";

            // Reset all state to start new session 
            // after successfully loggedIn
            postState().$reset();
            socialLinkState().$reset();
        },
        logout() {
            this.$reset();
        },
        hasVerifiedEmail(email_verified_at) {
            this.authData.hasVerifiedEmail = true;
            this.authData.user.email_verified_at = email_verified_at; 
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