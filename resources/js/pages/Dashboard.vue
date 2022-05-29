<template>
    <div class="">
        <div class="row align-items-md-stretch">
            <div class="col-md-6 mb-4">
                <div class="h-100 p-5 text-white bg-dark rounded-3">
                    <h2>Overview</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <button class="btn btn-outline-light" type="button">Get Started</button>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="h-100 p-5 bg-light border rounded-3">
                    <h2>Visitors Summary</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <button class="btn btn-outline-secondary" type="button">See Details</button>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="h-100 p-5 bg-primary-soft border rounded-3">
                    <h2>Active Users</h2>
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