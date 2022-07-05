<template>
    <button type="button" class="btn btn-outline-secondary" :disabled="processing">
        {{ text }}
    </button>
</template>

<script>
    export default {
        props: {
            processing: {
                default: false
            },
            text: {
                default: "Reset"
            },
        },
        methods: {

        },
    }
</script>