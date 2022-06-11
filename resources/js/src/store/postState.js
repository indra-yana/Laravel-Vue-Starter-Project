import { defineStore } from 'pinia';

const postState = defineStore('postState', {
    state: () => ({
        posts: null,
        meta: null,
        tempEditorData: null,
    }),
    getters: {
        getPosts() {
            return this.posts;
        },
        getTempEditorData() {
            return this.tempEditorData;
        },
    },
    actions:{
        setPosts(posts) {
            this.posts = posts;
        },
        setMeta(meta) {
            this.meta = meta;
        },
        setTempEditorData(data) {
            this.tempEditorData = data;
        },
    },
});

export { postState };