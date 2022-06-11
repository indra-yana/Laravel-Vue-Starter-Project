<template>
    <button :type="type" class="btn btn-success" :disabled="processing">
        {{ processing ? "Processing..." : text }}
    </button>
</template>

<script>
    export default {
        props: {
            processing: {
                default: false
            },
            text: {
                default: "Submit"
            },
            type: {
                default: "button"
            },
        },
        methods: {

        },
    }
</script>