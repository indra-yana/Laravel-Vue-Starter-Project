<template>
    <div class="">
        <div class="row mb-2 mx-auto">
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
                        <!-- <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg> -->
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
                        <!-- <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-auto">
            <h3 class="pb-4 mb-4 fst-italic border-bottom text-white">
                Recent Post
            </h3>
            <div class="col-md-8 p-4 mb-3 bg-light rounded">
                <article class="blog-post">
                    <h2 class="blog-post-title">Sample blog post</h2>
                    <p class="blog-post-meta">January 1, 2021 by <a href="#">Mark</a></p>

                    <p>
                        This blog post shows a few different types of content that's supported and styled with Bootstrap. Basic typography, lists, tables, images, code, and more are all supported as expected.
                        <a href="#" class="">Continue reading...</a>
                    </p>
                    <hr>
                </article>
                
                <article class="blog-post">
                    <h2 class="blog-post-title">Other blog post</h2>
                    <p class="blog-post-meta">December 23, 2020 by <a href="#">Mark</a></p>

                    <p>
                        This blog post shows a few different types of content that's supported and styled with Bootstrap. Basic typography, lists, tables, images, code, and more are all supported as expected.
                        <a href="#" class="">Continue reading...</a>
                    </p>
                    <hr>
                </article>

                <nav aria-label="Page navigation example ">
                    <ul class="pagination justify-content-end">
                        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Prev</a></li>
                        <li class="page-item active" aria-current="page"><span class="page-link">1</span></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>
            </div>

            <div class="col-md-4">
                <div class="position-sticky" style="top: 2rem;">
                    <div class="p-4 mb-3 bg-light rounded">
                        <h4 class="fst-italic">About</h4>
                        <p class="mb-0">Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.</p>
                    </div>

                    <div class="p-4 mb-3 bg-light rounded">
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

                    <div class="p-4 mb-3 bg-primary-soft rounded">
                        <h4 class="fst-italic">Find Me</h4>
                        <ol class="list-unstyled">
                            <li><a href="#">GitHub</a></li>
                            <li><a href="#">Twitter</a></li>
                            <li><a href="#">Facebook</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        created() {
            this.getBlog();
            this.$event.emit('breadcrumbs', { 
                title: this.$route.meta.title, 
                breadcrumbs: {
                    '#': 'My Posts',
                } 
            });
        },
        methods: {
            async getBlog() {
                // TODO
            }
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