<template>
    <div v-if="alert.show" class="alert mb-3 alert-dismissible fade show" :class="{'alert-success': alert.type == 'success', 'alert-danger': alert.type == 'error', 'alert-warning': alert.type == 'warning', 'alert-info': alert.type == 'info'}" role="alert">
        <h4 v-if="title" class="alert-heading m-0 mb-1" v-html="title"></h4>
        <p class="m-0" v-html="alert.message"></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" @click="resetAlert()"></button>
    </div>
</template>

<script>
    import { Toast } from '.././src/plugin/alert.js';

    export default {
        data() {
            return {
                title: '',
                alert: {
                    show: false,
                    type: 'info',
                    message: '',
                },
                closeTimeout: null,
            }
        },
        created() {
            // Notify to user if session has expired, triggered by 401 unauthorize request 
            this.$event.on('session-inactive', (e) => {
                let message = e.message;
                this.alert = {
                    show: true,
                    type: "error",
                    message: message,
                };

                Toast.fire({ 
                    icon: 'error', 
                    title: message 
                });
            });

            // // Display flash message from any page
            this.$event.on('flash-message', (e) => {
                let { type = "alert-info", message, withToast = false } = e;
                this.alert = {
                    show: true,
                    type,
                    message,
                };

                if (withToast) {
                    Toast.fire({ 
                        icon: type, 
                        title: message 
                    });
                }
            });
        },
        methods: {
            onAlertClosed() {
                // this.$emit('alertClosed');
            },
            resetAlert() {
                this.alert = {};
            }
        },
        watch: {
            alert: function(val, oldVal) {
                switch (val.type) {
                    case 'success':
                        this.title = 'Well done!';
                        break;
                    case 'error':
                        this.title = 'Oh no! something went wrong';
                        break;
                    case 'warning':
                        this.title = 'Be careful!';
                        break;
                    case 'info':
                        this.title = 'Check this out!';
                        break;
                    default:
                        this.title = '';
                        break;
                }

                if (val.show) {
                    if (this.closeTimeout !== null) {
                        clearTimeout(this.closeTimeout);
                        this.closeTimeout = null;
                    }
                    
                    this.closeTimeout = setTimeout(() => {
                        this.resetAlert();
                        // this.closeTimeout = null;
                    }, 10 * 1000);
                } 
            }
        },
    }
</script>

<style>
    @import '@sweetalert2/theme-wordpress-admin/wordpress-admin.min.css';
</style>