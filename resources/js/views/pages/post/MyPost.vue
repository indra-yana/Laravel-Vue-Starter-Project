<template>
    <!-- <div class="row mb-2 mx-auto">
        <h3 class="pb-4 mb-4 fst-italic border-bottom text-white">
            Pinned Post
        </h3>
        <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
            <div class="col-md-6 px-0">
            <h1 class="display-4 fst-italic">Title of a latest pinned blog post</h1>
            <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently about what’s most interesting in this post’s contents.</p>
            <p class="lead mb-0"><a href="#" class="text-white fw-bold">Continue reading...</a></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative bg-primary-soft">
                <div class="col p-4 d-flex flex-column position-static">
                    <strong class="d-inline-block mb-2 text-primary">World</strong>
                    <h3 class="mb-0">Featured post</h3>
                    <div class="mb-1 text-muted">Nov 12</div>
                    <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.
                        <a href="#" class="">Continue reading</a>
                    </p>

                    <div>
                        <a href="#" class="">Edit</a> &bullet; 
                        <a href="#" class="">Delete</a>
                    </div>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <img class="" src="/images/sample-img2.jpg" width="200" height="250" alt="post-thumbnail">
                    <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative bg-primary-soft">
                <div class="col p-4 d-flex flex-column position-static">
                    <strong class="d-inline-block mb-2 text-success">Design</strong>
                    <h3 class="mb-0">Post title</h3>
                    <div class="mb-1 text-muted">Nov 11</div>
                    <p class="mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.
                        <a href="#" class="">Continue reading</a>
                    </p>
                    <div>
                        <a href="#" class="">Edit</a> &bullet; 
                        <a href="#" class="">Delete</a>
                    </div>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <img class="" src="/images/sample-img2.jpg" width="200" height="250" alt="post-thumbnail">
                    <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>
                </div>
            </div>
        </div>
    </div> -->
    <div class="row mx-auto">
        <div class="col-lg-8 pt-3 ps-2 pe-2 mb-3 bg-light rounded order-lg-1 order-2 p-0">
            
            <!-- <Spinner :processing='isProcessing'/> -->

            <div v-if="!posts" class="text-center">
                <h5>No data available</h5>
            </div>
            <div class="mt-3 mb-4" v-else>
                <!-- <article class="blog-post" v-for="(post, index) in posts" :key="post.id"> -->
                    <!-- <h2 class="blog-post-title">{{ post.title }}</h2>
                    <p class="blog-post-meta"><i class="far fa-calendar-alt"></i> {{ post.formated_created_at }} by <i class="fas fa-user"></i> <a href="#">{{ post.user.name }}</a></p>
                    <p v-html="getPostBody(post.formated_body)">
                    </p>
                    <hr> -->
                <!-- </article> -->
                <div class="row mb-2 mx-auto">
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3" v-for="(post, index) in posts" :key="post.id">
                        <div class="card card-hover shadow-sm" style="min-height: 270px;">
                            <img class="img-fluid border-bottom rounded-top" :src="post.thumbnail || '/images/sample-img3.jpg'" alt="post-thumbnail" style="width:100%; height:145px; object-fit: cover;">
                            <div class="card-body">
                            <p class="card-text fw-bold text-elipsis">{{ splitLongText(post.title, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center position-absolute bottom-0 start-50 translate-middle-x w-100 p-3">
                                <div class="btn-group">
                                <router-link :to="{ name: 'post.detail', params: { id: post.id }}" class="btn btn-sm btn-outline-secondary">View</router-link>
                                <router-link :to="{ name: 'post.update', params: { id: post.id }}" class="btn btn-sm btn-outline-secondary">Edit</router-link>
                                </div>
                                <small class="text-muted">{{ post.formated_created_at }}</small>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <nav aria-label="Page navigation example ">
                    <!-- <ul class="pagination justify-content-lg-end justify-content-center">
                        <template v-for="(link, index) in meta.links">
                            <li class="page-item" :class="{ 'disabled': !link.url, 'active': link.active }" :aria-current="link.active ? 'page' : ''">
                                <span class="page-link" v-html="link.label" v-if="link.active"></span>
                                <a class="page-link" href="#" @click.prevent="getPosts(changePage(link.url))" :aria-disabled="!link.active" v-html="link.label" v-else></a>
                            </li>
                        </template>
                    </ul> -->
                    <Pagination class="justify-content-lg-end justify-content-center table-responsive mt-5" :show-disabled="true" :data="meta" :limit="2" @pagination-change-page="getPosts">
                        <template #prev-nav>
                            <span>Prev</span>
                        </template>
                        <template #next-nav>
                            <span>Next</span>
                        </template>
                    </Pagination>
                </nav>
            </div>
        </div>

        <div class="col-lg-4 order-lg-2 order-1 p-0 ps-lg-3 mb-3">
            <div class="position-sticky d-grid gap-3" style="top: 4rem;">
                <div class="p-4 bg-primary-soft rounded">
                    <h4 class="fst-italic mb-4 text-center border-2 border-bottom pb-1">About</h4>
                    <div class="d-flex mb-4">
                        <div class="flex-shrink-0 ">
                            <img :src="user().avatar || '/images/user.png'" alt="avatar" width="62" height="62" class="rounded-circle border border-1 border-secondary shadow-sm">
                            <br>
                            <button type="button" class="btn btn-sm btn-link mt-1 w-100">Follow</button>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <p class="">Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-md btn-outline-primary w-100" id="btn-support">SUPPORT ME</button>
                </div>

                <div class="p-4 bg-light rounded">
                    <h4 class="fst-italic">Categories</h4>
                    <ol class="list-unstyled mb-0">
                        <li><a href="#">Laravel</a></li>
                        <li><a href="#">Codeigniter</a></li>
                        <li><a href="#">Vue JS</a></li>
                        <li><a href="#">React JS</a></li>
                        <li><a href="#">Angular JS</a></li>
                        <li><a href="#">Database</a></li>
                        <li><a href="#">Rest API</a></li>
                        <li><a href="#">Deployment</a></li>
                        <li><a href="#">Others</a></li>
                    </ol>
                </div>

                <div class="p-4 bg-light rounded">
                    <h4 class="fst-italic">Find Me</h4>
                    <div class="d-flex justify-content-start">
                        <div v-if="hasSocialLink">
                            <template v-for="(social, key, index) in socialLinks">
                                <a :href="social.base_url +social.link" class="btn m-2" :class="social.button" :title="key" v-if="social.link" target="_blank"><i :class="social.icon"> </i></a>                                
                            </template>
                        </div>
                        <div v-else>
                            <span><router-link :to="{ name: 'account.social' }">Add social link</router-link></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { splitLongText } from '@src/plugin/helper.js';
    import Pagination from 'laravel-vue-pagination';
    import Spinner from '@components/Spinner.vue';
    import { mapState } from 'pinia';
    import { authState } from '@src/store/authState.js';
    import { postState } from '@src/store/postState.js';
    import { socialLinkState } from '@src/store/socialLinkState.js';
    import $ from 'jquery';
    import PostService from '@src/services/PostService.js';
    import SocialLinkService from '@src/services/SocialLinkService.js';

    export default {
        components: {
            Pagination,
            Spinner
        },
        data() {
            return {
                isProcessing: false,
                routeName: this.$route.meta.title,
                postService: new PostService(),
                socialLinkService: new SocialLinkService(),
            }
        },
        async created() {
            this.$event.emit('breadcrumbs', { 
                title: this.routeName, 
                breadcrumbs: {
                    '#': this.routeName,
                } 
            });

            if (!this.posts) {
                await this.getPosts();
            }

            if (!this.socialLinks) {
                await this.getSocialink();
            }
        },
        computed: {
            ...mapState(authState, ['auth']),
            ...mapState(postState, ['posts', 'meta', 'setPosts', 'setMeta']),
            ...mapState(socialLinkState, ['socialLinks', 'setSocialLinks']),
            hasSocialLink() {
                if (this.socialLinks) {
                    let filtered = Object.entries(this.socialLinks).filter(([key, value]) => {
                        return value.link != null;
                    });

                    return filtered.length > 0;
                }

                return false;
            },
        },
        methods: {
            splitLongText,
            changePage(link) { 
                const url = new URL(link);
                const qParams = new URLSearchParams(url.search);

                return qParams.get('page');
            },
            getPostBody(body) {
                // body = `${this.splitLongText(body, 191)} <a href="#" class="">Continue reading</a>`;
                return body ? `${body} <a href="#" class="">Continue reading...</a>` : 'N/A';
            },
            async getPosts(page = 1) {
                this.isProcessing = true;

                const result = await this.postService.posts(page);
                const { success, failure } = result;

                if (success) {
                    const { posts, meta } = success.data

                    this.setPosts(posts);
                    this.setMeta(meta);
                }
                
                if (failure) {
                    const { message, errors = {} } = failure;

                    this.$event.emit('flash-message', { message, type: "error" });
                }

                this.isProcessing = false;
            },
            async getSocialink() {
                this.isProcessing = true;

                const result = await this.socialLinkService.show(this.auth.user.id);
                const { success, failure } = result;

                if (success) {
                    const { social_links: socialLinks } = success.data;

                    this.setSocialLinks(socialLinks);
                }
                    
                if (failure) {
                    const { message, errors = {} } = failure;

                    this.$event.emit('flash-message', { message, type: "error" });
                }

                this.isProcessing = false;
            },
            user() {
                return this.auth.user ?? {};
            },
        },
    }
</script>

<style scoped>
    /* stylelint-disable selector-list-comma-newline-after */

    .blog-header {
        line-height: 1;
        border-bottom: 1px solid #e5e5e5;
    }

    .blog-header-logo {
        font-family: "Playfair Display", Georgia, "Times New Roman", serif/*rtl:Amiri, Georgia, "Times New Roman", serif*/;
        font-size: 2.25rem;
    }

    .blog-header-logo:hover {
        text-decoration: none;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: "Playfair Display", Georgia, "Times New Roman", serif/*rtl:Amiri, Georgia, "Times New Roman", serif*/;
    }

    .display-4 {
        font-size: 2.5rem;
    }
    @media (min-width: 768px) {
    .display-4 {
        font-size: 3rem;
    }
    }

    .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
    }

    .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
    }

    .nav-scroller .nav-link {
        padding-top: .75rem;
        padding-bottom: .75rem;
        font-size: .875rem;
    }

    .card-img-right {
        height: 100%;
        border-radius: 0 3px 3px 0;
    }

    .flex-auto {
        flex: 0 0 auto;
    }

    .h-250 { height: 250px; }
    @media (min-width: 768px) {
    .h-md-250 { height: 250px; }
    }

    /* Pagination */
    .blog-pagination {
        margin-bottom: 4rem;
    }
    .blog-pagination > .btn {
        border-radius: 2rem;
    }

    /*
    * Blog posts
    */
    .blog-post {
        margin-bottom: 1.2rem;
    }
    .blog-post-title {
        margin-bottom: .25rem;
        font-size: 2.5rem;
    }
    .blog-post-meta {
        margin-bottom: 1.25rem;
        color: #727272;
    }

    /*
    * Footer
    */
    .blog-footer {
        padding: 2.5rem 0;
        color: #727272;
        text-align: center;
        background-color: #f9f9f9;
        border-top: .05rem solid #e5e5e5;
    }
    .blog-footer p:last-child {
        margin-bottom: 0;
    }

    .text-elipsis {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* number of lines to show */
                line-clamp: 2; 
        -webkit-box-orient: vertical;
    }

    .card-hover:hover {
        transform: scale(1.02);
        box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
        cursor: pointer; 
    }
</style>