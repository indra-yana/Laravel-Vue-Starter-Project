<template>
    <div class="row mx-auto">
        <h2 class="mb-4 fst-italic text-white">
            Post Lists
        </h2>
        <div class="col-md-8 p-4 mb-3 bg-light rounded">
            
            <Spinner :processing='isProcessing'/>

            <div v-if="!isProcessing">
                <article class="blog-post" v-for="(post, index) in posts" :key="post.id">
                    <h2 class="blog-post-title">{{ post.title }}</h2>
                    <p class="blog-post-meta"><i class="far fa-calendar-alt"></i> {{ post.formated_created_at }} by <i class="fas fa-user"></i> <a href="#">{{ post.user.name }}</a></p>
                    <p>
                        {{ splitLongText(post.body, 191) }}
                        <a href="#" class="">Continue reading</a>
                    </p>
                    <hr>
                </article>
                <nav aria-label="Page navigation example ">
                    <!-- <ul class="pagination justify-content-lg-end justify-content-center">
                        <template v-for="(link, index) in meta.links">
                            <li class="page-item" :class="{ 'disabled': !link.url, 'active': link.active }" :aria-current="link.active ? 'page' : ''">
                                <span class="page-link" v-html="link.label" v-if="link.active"></span>
                                <a class="page-link" href="#" @click.prevent="getPosts(changePage(link.url))" :aria-disabled="!link.active" v-html="link.label" v-else></a>
                            </li>
                        </template>
                    </ul> -->
                    <Pagination class="justify-content-lg-end justify-content-center table-responsive" :show-disabled="true" :data="meta" :limit="2" @pagination-change-page="getPosts">
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

        <div class="col-md-4">
            <div class="position-sticky" style="top: 4rem;">
                <div class="p-4 mb-3 bg-primary-soft rounded">
                    <h4 class="fst-italic mb-4">Quick Actions</h4>
                    <button type="button" class="btn btn-md btn-primary w-100 mb-3 shadow" id="btn-support">CREATE</button>
                    <button type="button" class="btn btn-md btn-danger w-100 shadow" id="btn-support">DELETE SELECTED</button>
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

    export default {
        components: {
            Pagination,
            Spinner
        },
        data() {
            return {
                isProcessing: false,
                routeName: this.$route.meta.title,
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
        },
        computed: {
            ...mapState(authState, ['auth']),
            ...mapState(myPostState, ['posts', 'meta', 'setPosts', 'setMeta']),
        },
        methods: {
            splitLongText,
            changePage(link) { 
                const url = new URL(link);
                const qParams = new URLSearchParams(url.search);

                return qParams.get('page');
            },
            async getPosts(page = 1) {
                this.isProcessing = true;

                await this.$axios.get(`/api/v1/post?page=${page}`)
                    .then(({ data }) => {
                        const { posts, meta } = data.data

                        this.setPosts(posts);
                        this.setMeta(meta);

                        return data;
                    })
                    .catch(({ response: { data } }) => {
                        const { message, errors = {} } = data;

                        this.$event.emit('flash-message', { message, type: "error" });

                        return false;
                    })
                    .finally(() => {
                        this.isProcessing = false;
                    });
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
</style>