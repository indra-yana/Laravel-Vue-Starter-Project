<template>
    <div class="d-flex flex-column min-vh-100">

        <MainNavigation />

        <div class="container mt-5 mb-5 pt-5">
            <main class="row justify-content-center mb-3">
                <div class="col-md-12 mb-3">
                    <Alert :show="alert.show" :type="alert.type" :message="alert.message" @alertClosed="resetAlert()" />
                </div>
                <div class="col-md-12 mb-3">
                    <router-view/>
                </div>
            </main>
        </div>

        <Footer />

    </div>
</template>

<script>
    import MainNavigation from './MainNavigation.vue'
    import Footer from './Footer.vue';
    import { authState } from '.././store/authState.js';
  
    export default {
        components: {
            MainNavigation,
            Footer
        },
        data() {
            return {
                alert: {
                    show: false,
                    type: "",
                    message: "",
                },
            };
        },
        created() {
            this.$event.on('session-inactive', (e) => {
                let message = e.message;
                this.alert = {
                    show: true,
                    type: "error",
                    message: message,
                };
            });
            
            this.$event.on('flash-message', (e) => {
                let { type = "alert-info", message } = e;
                this.alert = {
                    show: true,
                    type,
                    message,
                };
            });

            authState().$subscribe((mutation, state) => {
                const { active, message } = state.session;
                if (!active && message) {
                    this.$event.emit('session-inactive', { 'message': message });
                }
            });
        },
        methods: {
            resetAlert() {
                this.alert = {};
            },
        },  
    };
</script>