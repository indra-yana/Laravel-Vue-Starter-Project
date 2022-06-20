<template>
    <div class="row mx-auto">
        <form @submit.prevent="save()" class="row p-0 m-0" autocomplete="off">
            <div class="col-xl-9 col-lg-8 p-4 mb-3 bg-light rounded order-lg-1 order-2 p-0">
                
                <Spinner :processing="isProcessing"/>

                <div class="card text-white rounded">
                    <div class="position-relative" style="width:100%; height:260px;">
                        <img :src="form.previewThumbnail" style="width: 100%; height: 100%; object-fit: cover;" alt="Thumbnail">
                        <div class="position-absolute top-0 end-0 p-3">
                            <div class="input-group mb-3">
                                <input type="file" name="thumbnail" id="thumbnail" class="form-control form-control-sm" :class="{'is-invalid': validation.thumbnail}" @change="handleInput('thumbnail', $event)" ref="file" accept="image/*" required>
                                <div v-if="validation.thumbnail" class="invalid-feedback mt-1" >
                                    <ul class="mb-0 ps-3">
                                        <li v-for="(error, index) in validation.thumbnail">{{ error }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="p-0 bg-post-title position-absolute bottom-0 start-50 translate-middle-x w-100 rounded-3">
                            <div class="form-group p-3">
                                <input type="text" name="title" class="form-control mb-2" :class="{'is-invalid': validation.title}" placeholder="Post title..." v-model="form.title" autofocus required >
                                <div v-if="validation.title" class="invalid-feedback mt-1" >
                                    <ul class="mb-0 ps-3">
                                        <li v-for="(error, index) in validation.title">{{ error }}</li>
                                    </ul>
                                </div>
                                <p class="card-text m-0"><i class="far fa-calendar-alt"></i> Thursday, 02-06-2022</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bd-callout bd-callout-warning">
                    <div id="content-editor"></div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 order-lg-2 order-1 p-0 ps-lg-3">
                <div class="position-sticky" style="top: 4rem;">
                    <div class="p-4 mb-3 bg-primary-soft rounded">
                        <h4 class="fst-italic mb-4 text-center border-2 border-bottom pb-1">Quick Actions</h4>
                        <label class="form-label fw-bold">Save as <span class="text-danger">*</span></label>
                        <div class="input-group mb-3">
                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" id="status-draft" class="form-check-input" :class="{'is-invalid': validation.status}" v-model="form.status" value="0" checked>
                                <label class="form-check-label" for="status-draft">Draft</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="status" id="status-publish" class="form-check-input" :class="{'is-invalid': validation.status}" v-model="form.status" value="1">
                                <label class="form-check-label" for="status-publish">Publish</label>
                            </div>
                            <!-- Trick to display invalid-feedback -->
                            <input type="radio" :class="{'is-invalid': validation.status}" hidden>
                            <div v-if="validation.status" class="invalid-feedback mt-1" >
                                <ul class="mb-0 ps-3">
                                    <li v-for="(error, index) in validation.status">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="d-flex justify-content-between">
                                <div class="form-check form-switch">
                                    <input type="checkbox" name="is_pinned" id="is_pinned" class="form-check-input" :class="{'is-invalid': validation.is_pinned}" v-model="form.is_pinned" true-value="1" false-value="0">
                                </div>
                                <label class="form-check-label fw-bold" for="is_pinned"> Pinned</label>
                            </div>
                            <!-- Trick to display invalid-feedback -->
                            <input type="checkbox" :class="{'is-invalid': validation.is_pinned}" hidden>
                            <div v-if="validation.is_pinned" class="invalid-feedback mt-1" >
                                <ul class="mb-0 ps-3">
                                    <li v-for="(error, index) in validation.is_pinned">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-5">
                            <SaveButton :type="'submit'" :class="['w-100', 'w-50-md', 'shadow-sm']" :text="`${'Save'}`" :processing="isProcessing" />
                            <div class="d-flex justify-content-start gap-2 mt-2">
                                <router-link :to="{ name: 'post' }" class="btn btn-sm btn-link  "><i class="fas fa-angle-left"></i> Back</router-link>
                                <button type="button" class="btn btn-sm btn-outline-primary shadow-sm" title="Refresh" @click="refresh()"><i class="fas fa-sync"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-secondary shadow-sm" title="Preview" @click="preview()"><i class="fas fa-eye"></i></button>
                                <button type="button" class="btn btn-sm btn-outline-danger shadow-sm" title="Clear Post Body" @click="clear()"><i class="fas fa-times-circle"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import Spinner from '../../components/Spinner.vue';
    import { mapState } from 'pinia';
    import { authState } from '../.././src/store/authState.js';
    import { postState } from '../.././src/store/postState.js';
    import { Toast } from '../../src/plugin/alert.js';
    import { editorJSConfig } from '../../src/plugin/editorJSConfig.js';
    import EditorJS from "@editorjs/editorjs";

    export default {
        components: {
            Spinner,
        },
        data() {
            return {
                isProcessing: false,
                validation: {},
                routeName: this.$route.meta.title,
                form: {
                    title: '',
                    body: {},
                    thumbnail: null,
                    status: 0,
                    is_pinned: 0,
                    previewThumbnail: '/images/sample-img3.jpg',
                },
                editor: null,
            }
        },
        async created() {
            this.$event.emit('breadcrumbs', { 
                title: this.routeName, 
                breadcrumbs: {
                    'post': 'Manage Post',
                    '#': this.routeName,
                } 
            });

            if (this.getCreateForm) {
                this.form = this.getCreateForm;
            }
        },
        mounted() {
            this.initEditor();
        },
        watch: {
            editor: function(val, oldVal) {
                val.isReady.then(() => {
                    this.refresh();
                    // console.log('Editor.js is ready to work!');
                }).catch((reason) => {
                    console.log(`Editor.js initialization failed because of ${reason}`)
                });
            },
            form: {
                handler(val, oldVal) {
                    this.setCreateForm(val);
                },
                deep: true
            }
        },
        computed: {
            ...mapState(authState, ['auth']),
            ...mapState(postState, ['getCreateForm', 'setCreateForm', 'setTempEditorData', 'getTempEditorData']),
        },
        methods: {
            handleInput(inputName, event = null) {
                switch (inputName) {
                    case 'title':
                        this.validation.title = null;
                        break;
                    case 'body':
                        this.validation.body = null;
                        break;
                    case 'thumbnail':
                        this.validation.thumbnail = null;
                        this.form.thumbnail = event.target.files[0];   // or this.$refs.file.files.item(0);
                        this.form.previewThumbnail = URL.createObjectURL(this.form.thumbnail);
                        break;
                    default:
                        break;
                }
            },
            initEditor() {
                this.editor = new EditorJS(editorJSConfig);
            },
            renderEditorData(data) {
                if (data != null) { 
                    this.editor.blocks.render(data); 
                }
            },
            save() {
                this.editor.save().then(blocks => {
                    if (!blocks.blocks.length) {
                        Toast.fire({ 
                            icon: 'warning', 
                            title: 'The post body is empty.' 
                        });

                        return false;
                    };
                    
                    this.form.body = JSON.stringify(blocks);
                    this.setTempEditorData(blocks);
                    this.create();
                });
            },
            preview() {
                // TODO
            },
            clear() {
                this.editor.blocks.clear();
                this.setTempEditorData(null);
            },
            resetForm() {
                this.clear();
                this.setCreateForm(null);
            },
            refresh() {
                this.renderEditorData(this.getTempEditorData);
            },
            async create() {
                this.isProcessing = true;
                this.validation = {};

                const options = { headers: {'Content-Type': 'multipart/form-data' }};
                const formData = new FormData();

                for (const item in this.form) {
                    if (this.form[item] != null) {
                        formData.append(item, this.form[item]);
                    }
                }

                await this.$axios.post('/api/v1/post/create', formData, options)
                    .then(({ data }) => {
                        const { message = 'Success!' } = data;
                        
                        this.resetForm();
                        this.$event.emit('flash-message', { message, type: "success", withToast: true });
                        this.$router.push({name: 'post'});
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;

                        this.validation = errors;
                        this.$event.emit('flash-message', { message, type: "error", withToast: true });
                    }).finally(() => {
                        this.isProcessing = false;
                    });
            }
        },
    }
</script>

<style >
    .ce-toolbar__actions {
        right: 110%;
    }

    .ce-block__content {
        max-width: 85%;
    }

    @media screen and (max-width: 1366px) {
        .ce-toolbar__actions {
            right: -5px;
        }
    }

    @media screen and (max-width: 1280px) {
        .ce-toolbar__actions {
            right: -5px;
        }
    }

    @media screen and (max-width: 1024px) {
        .ce-toolbar__actions {
            right: -5px;
        }
    }

    @media (max-width: 650px) {
        .ce-toolbar__actions {
            right: auto;
        }
    }

    .bd-callout {
        padding: 1.25rem;
        margin-top: 1.25rem;
        margin-bottom: 1.25rem;
        border: 1px solid #e9ecef;
        border-left-width: 0.25rem;
        border-radius: 0.25rem;
    }

    .bd-callout-warning {
        border-left-color: #f0ad4e;
    }

    .bg-post-title {
        background: -moz-linear-gradient(top,  rgba(0,0,0,0) 0%, rgba(0,0,0,0.65) 100%);
        background: -webkit-linear-gradient(top,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%);
        background: linear-gradient(to bottom,  rgba(0,0,0,0) 0%,rgba(0,0,0,0.65) 100%);
        /* filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00000000', endColorstr='#a6000000',GradientType=0 ); */
    }
</style>