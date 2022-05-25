<template>
    <button type="button" class="btn btn-outline-warning" :disabled="processing">
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