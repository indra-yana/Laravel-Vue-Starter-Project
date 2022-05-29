<template>
    <div class="">
        <div class="row align-items-md-stretch">
            <div class="col-md-6 mb-4">
                <div class="h-100 p-5 bg-primary-soft border rounded-3">
                    <h2>My Example Blog</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <button class="btn btn-outline-secondary" type="button">See Details</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        created() {
            this.getBlog();
            this.$event.emit('breadcrumbs', { 
                title: this.$route.meta.title, 
                breadcrumbs: {
                    '#': 'My Blog',
                } 
            });
        },
        methods: {
            async getBlog() {
                // TODO
            }
        },
    }
</script>