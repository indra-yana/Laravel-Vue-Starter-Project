<template>
    <div class="row d-flex align-items-center justify-content-center w-100 min-vh-100">
        <div class="col-md-8">
            <div class="alert mb-3 alert-dismissible fade show alert-danger" role="alert">
                <h4 class="alert-heading m-0 mb-1" >404</h4>
                <p class="m-0">Page not found</p>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <hr>
                <p class="mb-2">We are sorry but the page you are looking for does not exist. You could return to the home page by click the button bellow.</p>
                <router-link :to="{ name: 'landing' }" class="btn btn-outline-secondary btn-sm">Home</router-link>
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
           
        },
        methods: {
            
        },
    }
</script>