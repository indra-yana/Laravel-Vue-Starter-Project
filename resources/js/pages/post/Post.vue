<template>
    <div class="row mx-auto">
        <h2 class="mb-4 fst-italic text-white">
            Post Lists
        </h2>
        <div class="col-lg-9 p-4 mb-3 bg-light rounded order-lg-1 order-2 p-0">
            
            <Spinner :processing='isProcessing'/>

            <div class="table-responsive p-2">
                <table class="table table-striped pb-3 pt-3" id="dtPost">
                    <thead class="">
                        <tr>
                            <th scope="col" class="text-left">Title</th>
                            <th scope="col" class="text-left">Body</th>
                            <th scope="col" class="text-center">Created At</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <template v-for="(post, index) in posts" :key="post.id">
                            <tr >
                                <td scope="col" class="text-left">{{ post.title }}</td>
                                <td scope="col" class="text-left">{{ post.body }}</td>
                                <td scope="col" class="text-center">{{ post.formated_created_at }}</td>
                                <td scope="col" class="text-center">Edit | Delete</td>
                            </tr>
                        </template> -->
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-3 order-lg-2 order-1 p-0 ps-lg-3">
            <div class="position-sticky" style="top: 4rem;">
                <div class="p-4 mb-3 bg-primary-soft rounded">
                    <h4 class="fst-italic mb-4 text-center border-2 border-bottom pb-1">Quick Actions</h4>
                    <button type="button" class="btn btn-md btn-primary w-100 w-50-md mb-3 shadow" id="btn-support">CREATE</button>
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
                routeName: this.$route.meta.title,
                dataTable: null,
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
        mounted() {
            if (this.dataTable == null) {
                this.dataTable = $('#dtPost').DataTable({
                    stateSave: true,
                    processing: true,
                    responsive: true,
                    serverSide: true,
                    destroy: false,
                    ajax: {
                        url: '/api/v1/post/dt-table.json',
                        type: 'GET',
                        // For custom filtered
                        // data: (data) => {
                        //     data.dataFiltered = $('#form-filters').serializeJSON();
                        // }
                    },
                    columns: [
                        // { data: 'DT_Number', name: 'DT_Number', width: '5%', orderable: false, searchable: false },
                        {
                            data: 'title',
                            name: 'title',
                            width: '15%',
                            defaultContent: 'N/A'
                        },
                        {
                            data: 'body',
                            name: 'body',
                            width: '20%',
                            defaultContent: 'N/A'
                        },
                        {
                            data: 'formated_created_at',
                            name: 'formated_created_at',
                            searchable: false,
                            width: '15%',
                            defaultContent: 'N/A'
                        },
                        {
                            // data: 'formated_created_at',
                            name: 'formated_created_atactions',
                            width: '10%',
                            searchable: false,
                            defaultContent: 'N/A'
                        },
                    ]
                });
            }
        },
        computed: {
            ...mapState(authState, ['auth']),
            ...mapState(myPostState, ['posts', 'meta', 'setPosts', 'setMeta']),
        },
        methods: {
            splitLongText,
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

<style>
    @import '/vendor/datatable/DataTables-1.11.4/css/dataTables.bootstrap5.min.css';
    @import '/vendor/datatable/ext/Responsive-2.2.9/css/responsive.bootstrap5.min.css';
</style>