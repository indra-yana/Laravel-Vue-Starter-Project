<template>
    <div class="row mx-auto">
        <form @submit.prevent="save()" class="row p-0 m-0" autocomplete="off">
            <div class="col-xl-9 col-lg-8 p-4 mb-3 bg-light rounded order-lg-1 order-2 p-0">
                
                <!-- <Spinner :processing="isProcessing"/> -->

                <div  v-show="!isProcessing">
                    <div class="card text-white rounded">
                        <div class="position-relative" style="width:100%; height:260px;">
                            <img :src="form.previewThumbnail" style="width: 100%; height: 100%; object-fit: cover;" alt="Thumbnail">
                            <div class="p-0 bg-post-title position-absolute bottom-0 start-50 translate-middle-x w-100 rounded-3">
                                <div class="form-group p-3">
                                    <h3>{{ form.title }}</h3>
                                    <p class="card-text m-0"><i class="far fa-calendar-alt"></i> {{ form.formated_updated_at }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bd-callout bd-callout-warning">
                        <div id="content-editor"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 order-lg-2 order-1 p-0 ps-lg-3">
                <div class="position-sticky" style="top: 4rem;">
                    <div class="p-4 mb-3 bg-primary-soft rounded">
                        <h4 class="fst-italic mb-4 text-center border-2 border-bottom pb-1">Related Post</h4>
                        <div class="d-flex justify-content-start gap-2 mt-2">
                            <span>No data available</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    import Spinner from '@components/Spinner.vue';
    import { mapState } from 'pinia';
    import { authState } from '@src/store/authState.js';
    import { postState } from '@src/store/postState.js';
    import { Toast } from '@src/plugin/alert.js';
    import { editorJSConfig } from '@src/plugin/editorJSConfig.js';
    import EditorJS from "@editorjs/editorjs";
    import PostService from '@src/services/PostService.js';

    export default {
        components: {
            Spinner,
        },
        data() {
            return {
                isProcessing: false,
                routeName: this.$route.meta.title,
                form: {
                    id: this.$route.params.id,
                    title: '',
                    body: {},
                    thumbnail: null,
                    status: 0,
                    is_pinned: 0,
                    formated_updated_at: null,
                    previewThumbnail: '/images/sample-img3.jpg',
                },
                editor: null,
                postService: new PostService(),
            }
        },
        async created() {
            this.getPost();
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
        },
        computed: {
            ...mapState(authState, ['auth']),
            ...mapState(postState, ['setTempEditorData', 'getTempEditorData']),
        },
        methods: {
            initEditor() {
                this.editor = new EditorJS({ readOnly: true, ...editorJSConfig });
            },
            renderEditorData(data) {
                if (data != null) { 
                    this.editor.blocks.render(data); 
                }
            },
            refresh() {
                this.renderEditorData(this.getTempEditorData);
            },
            async getPost() {
                this.isProcessing = true;

                const result = await this.postService.show(this.form.id);
                const { success, failure } = result;

                if (success) {
                    const { id, title, body, status, is_pinned, formated_updated_at, thumbnail: previewThumbnail } = success.data;
                    this.form = {
                        id,
                        title,
                        body,
                        status,
                        is_pinned,
                        thumbnail: null,
                        previewThumbnail: previewThumbnail ?? this.form.previewThumbnail,
                        formated_updated_at,
                    };

                    this.setTempEditorData(body);
                }
                    
                if (failure) {
                    const { message = 'Error!', errors = {} } = failure;

                    this.$event.emit('flash-message', { message, type: "error", withToast: true });
                }

                this.isProcessing = false;
            },
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