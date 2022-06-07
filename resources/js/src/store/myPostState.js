import { defineStore } from 'pinia';

const myPostState = defineStore('myPostState', {
    state: () => ({
        posts: null,
        meta: null,
    }),
    getters: {
        getPosts() {
            return this.posts;
        },
    },
    actions:{
        setPosts(posts) {
            this.posts = posts;
        },
        setMeta(meta) {
            this.meta = meta;
        },
    },
});

export { myPostState };