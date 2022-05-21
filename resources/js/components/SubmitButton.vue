<template>
    <button type="submit" class="btn btn-primary" :disabled="processing">
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
        },
        methods: {

        },
    }
</script>