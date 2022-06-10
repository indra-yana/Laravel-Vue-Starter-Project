<template>
    <div class="row mx-auto">
        <div class="col-lg-9 p-4 mb-3 bg-light rounded order-lg-1 order-2 p-0">
            
            <Spinner :processing='isProcessing'/>

            <div class="card text-white rounded">
                <div class="position-relative" style="width:100%; height:260px;">
                    <img :src="form.previewThumbnail" style="width: 100%; height: 100%; object-fit: cover;" alt="Thumbnail">
                    <div class="position-absolute top-0 end-0 p-2">
                        <div class="input-group mb-3">
                            <input type="file" name="thumbnail" id="thumbnail" class="form-control form-control-sm" @change="handleInput('thumbnail', $event)" ref="file" accept="image/*">
                        </div>
                    </div>
                    <div class="p-0 bg-post-title position-absolute bottom-0 start-50 translate-middle-x w-100 rounded-3">
                        <div class="form-group p-3">
                            <input type="text" name="title" class="form-control mb-2" placeholder="Post title..." autofocus required >
                            <p class="card-text m-0"><i class="far fa-calendar-alt"></i> Thursday, 02-06-2022</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bd-callout bd-callout-warning">
                <h3 id="making-popovers-work-for-keyboard-and-assistive-technology-users">Making popovers work for keyboard and assistive technology users</h3>
                <p>To allow keyboard users to activate your popovers, you should only add them to HTML elements that are traditionally keyboard-focusable and interactive (such as links or form controls). Although arbitrary HTML elements (such as <code>&lt;span&gt;</code>s) can be made focusable by adding the <code>tabindex="0"</code> attribute, this will add potentially annoying and confusing tab stops on non-interactive elements for keyboard users, and most assistive technologies currently do not announce the popover’s content in this situation. Additionally, do not rely solely on <code>hover</code> as the trigger for your popovers, as this will make them impossible to trigger for keyboard users.</p>
                <p>While you can insert rich, structured HTML in popovers with the <code>html</code> option, we strongly recommend that you avoid adding an excessive amount of content. The way popovers currently work is that, once displayed, their content is tied to the trigger element with the <code>aria-describedby</code> attribute. As a result, the entirety of the popover’s content will be announced to assistive technology users as one long, uninterrupted stream.</p>
                <p>Additionally, while it is possible to also include interactive controls (such as form elements or links) in your popover (by adding these elements to the <code>allowList</code> of allowed attributes and tags), be aware that currently the popover does not manage keyboard focus order. When a keyboard user opens a popover, focus remains on the triggering element, and as the popover usually does not immediately follow the trigger in the document’s structure, there is no guarantee that moving forward/pressing <kbd>TAB</kbd> will move a keyboard user into the popover itself. In short, simply adding interactive controls to a popover is likely to make these controls unreachable/unusable for keyboard users and users of assistive technologies, or at the very least make for an illogical overall focus order. In these cases, consider using a modal dialog instead.</p>
            </div>
        </div>
        <div class="col-lg-3 order-lg-2 order-1 p-0 ps-lg-3">
            <div class="position-sticky" style="top: 4rem;">
                <div class="p-4 mb-3 bg-primary-soft rounded">
                    <h4 class="fst-italic mb-4 text-center border-2 border-bottom pb-1">Quick Actions</h4>
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-sm btn-success w-100 w-50-md shadow-sm">Save</button>
                        <button type="button" class="btn btn-sm btn-secondary w-100 w-50-md shadow-sm">Preview</button>
                        <router-link :to="{ name: 'post' }" class="btn btn-link w-100 ">Back</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { splitLongText } from '../../src/plugin/helper.js';
    import Pagination from 'laravel-vue-pagination';
    import Spinner from '../../components/Spinner.vue';
    import { mapState } from 'pinia';
    import { authState } from '../.././src/store/authState.js';
    import { myPostState } from '../.././src/store/myPostState.js';
    import $ from 'jquery';

    import 'datatables.net-bs5';
    import 'datatables.net-responsive-bs5';
    import 'datatables.net-buttons-bs5';
    import 'datatables.net-colreorder-bs5';

    export default {
        components: {
            Pagination,
            Spinner
        },
        data() {
            return {
                isProcessing: false,
                validation: {},
                routeName: this.$route.meta.title,
                form: {
                    title: '',
                    body: '',
                    thumbnail: null,
                    previewThumbnail: '/images/sample-img1.jpg',
                },
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
        },
        mounted() {
        },
        computed: {
            ...mapState(authState, ['auth']),
            ...mapState(myPostState, ['posts', 'meta', 'setPosts', 'setMeta']),
        },
        methods: {
            splitLongText,
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
        },
    }
</script>

<style>
    @import '/vendor/datatable/DataTables-1.11.4/css/dataTables.bootstrap5.min.css';
    @import '/vendor/datatable/ext/Responsive-2.2.9/css/responsive.bootstrap5.min.css';
</style>

<style scoped>
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