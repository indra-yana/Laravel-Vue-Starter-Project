import { defineStore } from 'pinia';

const socialLinkState = defineStore('socialLinkState', {
    state: () => ({
        socialLinks: null,
    }),
    getters: {
        getSocialLinks() {
            return this.socialLinks;
        },
    },
    actions:{
        setSocialLinks(socialLinks) {
            this.socialLinks = socialLinks;
        },
    },
});

export { socialLinkState };