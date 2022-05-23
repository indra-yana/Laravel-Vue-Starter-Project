import { defineStore } from 'pinia'
import SecureLS from "secure-ls";

const ls = new SecureLS({ isCompression: false });
const registerState = defineStore('registerState', {
    state: () => ({
        formData: null
    }),
    getters: {
        getFormData() {
            return this.formData;
        },
    },
    actions:{
        setFormData(formData) {
            this.formData = formData;
        },
        resetFormData() {
            this.$reset();
        },
    },
    persist: {
        key: 'register-state',
        paths: ['formData'],
        storage: {
            getItem: (key) => ls.get(key),
            setItem: (key, value) => ls.set(key, value),
            removeItem: (key) => ls.remove(key)
        },
    },
});

export { registerState };