import { defineStore } from 'pinia';

const postState = defineStore('postState', {
    state: () => ({
        posts: null,
        meta: null,
        tempEditorData: null,
        createForm: null,
    }),
    getters: {
        getPosts() {
            return this.posts;
        },
        getTempEditorData() {
            return this.tempEditorData;
        },
        getCreateForm() {
            return this.createForm;
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
        setCreateForm(form) {
            this.createForm = form;
        },
    },
});

export { postState };