<template>
    <div v-if="show" class="alert mb-3 alert-dismissible fade show" :class="{'alert-success': type == 'success', 'alert-danger': type == 'error', 'alert-warning': type == 'warning', 'alert-info': type == 'info'}" role="alert">
        <h4 v-if="title" class="alert-heading m-0 mb-1" v-html="title"></h4>
        <p class="m-0" v-html="message"></p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" @click="onAlertClosed()"></button>
    </div>
</template>

<script>
    export default {
        props: [
            'show',
            'type',
            'message',
        ],
        data() {
            return {
                title: '',
            }
        },
        watch: {
            type: function(val, oldVal) {
                switch (this.type) {
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
            }
        },
        methods: {
            onAlertClosed() {
                this.$emit('alertClosed');
            }
        },
    }
</script>