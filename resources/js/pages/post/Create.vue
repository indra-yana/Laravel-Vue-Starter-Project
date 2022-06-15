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

    // Editor JS
    import EditorJS from "@editorjs/editorjs";
    import Header from '@editorjs/header';
    import List from '@editorjs/list';
    import CodeTool from '@editorjs/code';
    import Paragraph from '@editorjs/paragraph';
    import Embed from '@editorjs/embed';
    import Table from '@editorjs/table';
    import Checklist from '@editorjs/checklist';
    import Marker from '@editorjs/marker';
    import Warning from '@editorjs/warning';
    import RawTool from '@editorjs/raw';
    import Quote from '@editorjs/quote';
    import InlineCode from '@editorjs/inline-code';
    import Delimiter from '@editorjs/delimiter';
    import SimpleImage from '@editorjs/simple-image';
    import LinkTool from '@editorjs/link';

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
                editorConfig: {
                    holder: "content-editor",
                    placeholder: 'Write your post here...',
                    tools:{
                        header: {
                            class: Header,
                            config: {
                                placeholder: 'Enter a header',
                                levels: [1, 2, 3, 4, 5],
                                defaultLevel: 2,
                            }
                        },
                        list: {
                            class: List,
                            inlineToolbar: true,
                        },
                        code: {
                            class: CodeTool
                        },
                        paragraph: {
                            class: Paragraph,
                        },
                        embed: {
                            class: Embed,
                            config: {
                            services: {
                                    youtube: true,
                                    coub: true,
                                    imgur: true
                                }
                            }
                        },
                        table: {
                            class: Table,
                            inlineToolbar: true,
                            config: {
                                rows: 2,
                                cols: 3,
                            },
                        },
                        checklist: {
                            class: Checklist,
                        },
                        Marker: {
                            class: Marker,
                            shortcut: 'CMD+SHIFT+M',
                        },
                        warning: {
                            class: Warning,
                            inlineToolbar: true,
                            shortcut: 'CMD+SHIFT+W',
                            config: {
                                titlePlaceholder: 'Title',
                                messagePlaceholder: 'Message',
                            },
                        },
                        raw: RawTool,
                        quote: {
                            class: Quote,
                            inlineToolbar: true,
                            shortcut: 'CMD+SHIFT+O',
                            config: {
                                quotePlaceholder: 'Enter a quote',
                                captionPlaceholder: 'Quote\'s author',
                            },
                        },
                        inlineCode: {
                            class: InlineCode,
                            shortcut: 'CMD+SHIFT+M',
                        },
                        delimiter: Delimiter,
                        image: SimpleImage,
                        linkTool: {
                            class: LinkTool,
                            config: {
                                endpoint: "",
                            }
                        },
                    },
                    onReady: () => {
                        // console.log('Editor\'s content changed!');
                    },
                    onChange: (args) => {
                        // console.log('Editor\'s content changed!');
                    },
                },
                editorData: {
                    "time": 1591362820044,
                    "blocks": [
                        {
                            "type" : "header",
                            "data" : {
                                "text" : "Editor.js",
                                "level" : 2
                            }
                        },
                        {
                            "type" : "paragraph",
                            "data" : {
                                "text" : "Hey. Meet the new Editor. On this page you can see it in action — try to edit this text."
                            }
                        },
                        {
                            "type" : "header",
                            "data" : {
                                "text" : "Key features",
                                "level" : 3
                            }
                        },
                        {
                            "type" : "list",
                            "data" : {
                                "style" : "unordered",
                                "items" : [
                                    "It is a block-styled editor",
                                    "It returns clean data output in JSON",
                                    "Designed to be extendable and pluggable with a simple API"
                                ]
                            }
                        },
                        {
                            "type" : "header",
                            "data" : {
                                "text" : "What does it mean «block-styled editor»",
                                "level" : 3
                            }
                        },
                        {
                            "type" : "paragraph",
                            "data" : {
                                "text" : "Workspace in classic editors is made of a single contenteditable element, used to create different HTML markups. Editor.js <mark class=\"cdx-marker\">workspace consists of separate Blocks: paragraphs, headings, images, lists, quotes, etc</mark>. Each of them is an independent contenteditable element (or more complex structure) provided by Plugin and united by Editor's Core."
                            }
                        },
                        {
                            "type" : "paragraph",
                            "data" : {
                                "text" : "There are dozens of <a href=\"https://github.com/editor-js\">ready-to-use Blocks</a> and the <a href=\"https://editorjs.io/creating-a-block-tool\">simple API</a> for creation any Block you need. For example, you can implement Blocks for Tweets, Instagram posts, surveys and polls, CTA-buttons and even games."
                            }
                        },
                        {
                            "type" : "header",
                            "data" : {
                                "text" : "What does it mean clean data output",
                                "level" : 3
                            }
                        },
                        {
                            "type" : "paragraph",
                            "data" : {
                                "text" : "Classic WYSIWYG-editors produce raw HTML-markup with both content data and content appearance. On the contrary, Editor.js outputs JSON object with data of each Block. You can see an example below"
                            }
                        },
                        {
                            "type" : "paragraph",
                            "data" : {
                                "text" : "Given data can be used as you want: render with HTML for <code class=\"inline-code\">Web clients</code>, render natively for <code class=\"inline-code\">mobile apps</code>, create markup for <code class=\"inline-code\">Facebook Instant Articles</code> or <code class=\"inline-code\">Google AMP</code>, generate an <code class=\"inline-code\">audio version</code> and so on."
                            }
                        },
                        {
                            "type" : "paragraph",
                            "data" : {
                                "text" : "Clean data is useful to sanitize, validate and process on the backend."
                            }
                        },
                        {
                            "type" : "delimiter",
                            "data" : {}
                        },
                        {
                            "type" : "paragraph",
                            "data" : {
                                "text" : "We have been working on this project more than three years. Several large media projects help us to test and debug the Editor, to make it's core more stable. At the same time we significantly improved the API. Now, it can be used to create any plugin for any task. Hope you enjoy. 😏"
                            }
                        },
                        {
                            "type" : "image",
                            "data" : {
                                "file" : {
                                    "url" : "https://codex.so/public/app/img/external/codex2x.png"
                                },
                                "caption" : "",
                                "withBorder" : false,
                                "stretched" : false,
                                "withBackground" : false
                            }
                        },
                    ],
                    "version" : "2.18.0"
                }
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
                this.editor = new EditorJS(this.editorConfig);
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
                    formData.append(item, this.form[item]);
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