import { defineStore } from 'pinia';

const postState = defineStore('postState', {
    state: () => ({
        posts: null,
        meta: null,
        tempEditorData: null,
        createForm: null,
        updateForm: null,
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
        getUpdateForm() {
            return this.updateForm;
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
        setUpdateForm(form) {
            this.updateForm = form;
        },
    },
});

export { postState };