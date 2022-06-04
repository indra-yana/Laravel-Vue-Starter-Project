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

        <footer class="footer mt-auto py-1 bg-primary-soft bg-dark">
            <div class="container">
                <div class="d-flex bd-highlight">
                    <div class="flex-grow-1 bd-highlight text-white">
                    <figure class="mt-2">
                        <blockquote class="blockquote text-white">
                            <p>Get in touch.</p>
                        </blockquote>
                        <figcaption class="blockquote-footer mb-0 text-white">
                            &copy; <cite title="Source Title"><a href="mailto:indra.ndra26@gmail.com" class="text-white">indra.ndra26@gmail.com</a> </cite>
                        </figcaption>
                    </figure>
                </div>
                    <div class="bd-highlight text-white">
                        <figure class="mt-2">
                            <blockquote class="blockquote text-white">
                                <p>Laravue SPA.</p>
                            </blockquote>
                        </figure>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
    import MainNavigation from './MainNavigation.vue'
    import { authState } from '.././store/authState.js';
  
    export default {
        components: {
            MainNavigation
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