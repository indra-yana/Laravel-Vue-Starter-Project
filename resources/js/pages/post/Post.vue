<template>
    <div class="row mx-auto">
        <div class="col-lg-9 p-4 mb-3 bg-light rounded order-lg-1 order-2 p-0">
            
            <Spinner :processing='isProcessing'/>

            <div class="table-responsive p-2" v-once>
                <table class="table table-striped pb-3 pt-3" id="dtPost">
                    <thead class="">
                        <tr>
                            <th scope="col" class="text-center">Title</th>
                            <th scope="col" class="text-center">Body</th>
                            <th scope="col" class="text-center">Created At</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-3 order-lg-2 order-1 p-0 ps-lg-3">
            <div class="position-sticky" style="top: 4rem;">
                <div class="p-4 mb-3 bg-primary-soft rounded">
                    <h4 class="fst-italic mb-4 text-center border-2 border-bottom pb-1">Quick Actions</h4>
                    <router-link :to="{ name: 'post.create' }" class="btn btn-md btn-primary w-100 w-50-md mb-3 shadow-sm">Create</router-link>
                    <!-- <button type="button" class="btn btn-md btn-danger w-100 shadow" id="btn-support">DELETE SELECTED</button> -->
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
        },
        mounted() {
            this.buildDataTable();
        },
        computed: {
            ...mapState(authState, ['auth']),
            ...mapState(myPostState, ['posts', 'meta', 'setPosts', 'setMeta']),
        },
        methods: {
            splitLongText,
            buildDataTable() {
                this.dataTable = $('#dtPost').DataTable({
                    stateSave: true,
                    processing: true,
                    responsive: true,
                    serverSide: true,
                    destroy: true,
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
                            className: 'text-left',
                            defaultContent: 'N/A',
                        },
                        {
                            data: 'body',
                            name: 'body',
                            width: '20%',
                            className: 'text-left',
                            defaultContent: 'N/A'
                        },
                        {
                            data: 'formated_created_at',
                            name: 'formated_created_at',
                            searchable: false,
                            width: '15%',
                            className: 'text-center',
                            defaultContent: 'N/A'
                        },
                        {
                            // data: 'formated_created_at',
                            name: 'formated_created_atactions',
                            width: '10%',
                            searchable: false,
                            className: 'text-center',
                            defaultContent: 'N/A'
                        },
                    ]
                });
            }
        },
    }
</script>

<style>
    @import '/vendor/datatable/DataTables-1.11.4/css/dataTables.bootstrap5.min.css';
    @import '/vendor/datatable/ext/Responsive-2.2.9/css/responsive.bootstrap5.min.css';
</style>