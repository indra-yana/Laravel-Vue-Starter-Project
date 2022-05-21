<template>
    <div v-if="show" class="alert mb-3 alert-dismissible fade show" :class="{'alert-success': type == 'success', 'alert-danger': type == 'error', 'alert-info': type == 'info'}" role="alert">
        {{ message }}
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
        methods: {
            onAlertClosed() {
                this.$emit('alertClosed');
            }
        },
    }
</script>