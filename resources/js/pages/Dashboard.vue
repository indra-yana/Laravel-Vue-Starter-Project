<template>
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="p-5 mb-4 bg-primary-soft rounded-3 border">
                    <h1 class="display-5 fw-bold">Overview</h1>
                    <p class=" fs-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                    <button class="btn btn-primary btn-lg" type="button">Get Started</button>
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
            this.getUser();
        },
        methods: {
            async getUser() {
                // Testing API call
                await this.$axios.get("/api/user")
                    .then(({ data }) => {
                        this.$event.emit('flash-message', { message: `Welcome back! ${data.name}`, type: "info" });
                        console.log(data);

                        return data;
                    })
                    .catch(({ response: { data } }) => {
                        console.log(data);

                        return false;
                    });
            }
        },
    }
</script>