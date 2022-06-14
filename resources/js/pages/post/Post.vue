<template>
    <div class="row mx-auto">
        <div class="col-lg-9 p-4 mb-3 bg-light rounded order-lg-1 order-2 p-0">
            
            <Spinner :processing='isProcessing'/>

            <div class="table-responsive p-2" v-show="!isProcessing" >
                <table class="table table-striped pb-3 pt-3" id="dtPost">
                    <thead class="">
                        <tr>
                            <th scope="col" class="text-center">Title</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Pinned</th>
                            <th scope="col" class="text-center">Last Updated</th>
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
    import { Toast, DeleteConfirm } from '../../src/plugin/alert.js';
    import Spinner from '../../components/Spinner.vue';
    import { mapState } from 'pinia';
    import { authState } from '../.././src/store/authState.js';
    import { postState } from '../.././src/store/postState.js';
    import $ from 'jquery';
    import Swal from 'sweetalert2';

    import 'datatables.net-bs5';
    import 'datatables.net-responsive-bs5';
    import 'datatables.net-buttons-bs5';
    import 'datatables.net-colreorder-bs5';

    export default {
        components: {
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
            let _this = this;

            $(document).on('click', '.delete', function(){
                let id = $(this).data('id');

                DeleteConfirm.fire({
                    title: 'Confirm to Delete',
                    html: 'Are you sure you want delete this data?'
                }).then((result) => {
                    if (result.isConfirmed) {
                        _this.delete(id);
                    }
                });
            });

            $(document).on('click', '.edit', function(){
                let id = $(this).data('id');
                _this.edit(id);
            });
        },
        computed: {
            ...mapState(authState, ['auth']),
            ...mapState(postState, ['posts', 'meta', 'setPosts', 'setMeta']),
        },
        methods: {
            splitLongText,
            async delete(id) {
                this.isProcessing = true;

                const formData = new FormData();
                formData.append('_method', 'DELETE');
                formData.append('id', id);

                await this.$axios.post('/api/v1/post/delete', formData)
                    .then(({ data }) => {
                        const { message = 'Success!' } = data;
                        
                        this.$event.emit('flash-message', { message, type: "success" });
                        this.dataTable.ajax.reload();

                        Toast.fire({
                            icon: 'success',
                            title: message
                        });
                    }).catch(({ response: { data } }) => {
                        const { message = 'Error!', errors = {} } = data;

                        this.validation = errors;
                        this.$event.emit('flash-message', { message, type: "error" });

                        Toast.fire({
                            icon: 'success',
                            title: message
                        });
                    }).finally(() => {
                        this.isProcessing = false;
                    });

                
            },
            async edit(id) {
                // TODO
                console.log('edit', id);
            },
            buildDataTable() {
                this.dataTable = $('#dtPost').DataTable({
                    stateSave: true,
                    processing: true,
                    responsive: true,
                    serverSide: true,
                    destroy: false,
                    autoWidth: false,
                    language: {
                        processing: '<i class="fa fa-spinner fa-spin fa-1x fa-fw"></i>&nbsp;&nbsp;Processing...',
                    },
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
                            width: '20%',
                            className: 'text-left',
                            defaultContent: 'N/A',
                        },
                        {
                            data: 'formated_status',
                            name: 'status',
                            width: '5%',
                            className: 'text-center',
                            defaultContent: 'N/A',
                            render: function ( data, type, row, meta ) {
                                return `<span class="badge ${row.status ? 'bg-success' : 'bg-secondary'}">${row.formated_status}</span>`;
                            }
                        },
                        {
                            data: 'is_pinned',
                            name: 'is_pinned',
                            width: '5%',
                            className: 'text-center',
                            defaultContent: 'N/A',
                            render: function ( data, type, row, meta ) {
                                return row.is_pinned ? `<i class="fas fa-thumbtack text-danger"></i>` : '';
                            }
                        },
                        {
                            data: 'formated_updated_at',
                            name: 'updated_at',
                            searchable: false,
                            width: '10%',
                            className: 'text-center',
                            defaultContent: 'N/A'
                        },
                        {
                            // data: 'formated_created_at',
                            name: 'actions',
                            width: '5%',
                            searchable: false,
                            orderable: false,
                            className: 'text-center',
                            defaultContent: 'N/A',
                            render: function ( data, type, row, meta ) {
                                let actions = [
                                    `<button type="button" class="btn btn-sm btn-outline-primary shadow-sm edit" data-id="${row.id}" title="Edit"><i class="fas fa-edit"></i></button>`,
                                    `<button type="button" class="btn btn-sm btn-outline-danger shadow-sm delete" data-id="${row.id}" title="Delete"><i class="fas fa-trash"></i></button>`,
                                ];

                                return actions.join('&nbsp;&nbsp;');
                            }
                        },
                    ]
                });
            },
        },
    }
</script>

<style>
    @import '/vendor/datatable/DataTables-1.11.4/css/dataTables.bootstrap5.min.css';
    @import '/vendor/datatable/ext/Responsive-2.2.9/css/responsive.bootstrap5.min.css';
    @import '@sweetalert2/theme-wordpress-admin/wordpress-admin.min.css';
</style>

<style>
    .dataTables_processing {
        position:absolute;
        top:50%;
        left:50%;
        right:50%;
        transform: translate(-50%,-50%);
    }
</style>