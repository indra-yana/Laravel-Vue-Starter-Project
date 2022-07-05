import { defineStore } from 'pinia';

const loaderState = defineStore('loaderState', {
    state: () => ({
        processing: false,
    }),
    getters: {
        isProcessing() {
            return this.processing;
        },
    },
    actions: {
        setProcessing(processing) {
            this.processing = processing;
        },
    },
});

export { loaderState };