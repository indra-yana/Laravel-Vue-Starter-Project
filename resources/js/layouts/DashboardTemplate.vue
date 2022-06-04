<template>
    <div class="d-flex flex-column min-vh-100">
        
        <DashboardNavigation/>

        <div class="container mt-5 mb-5 pt-5">
            <header class="mb-4 border-bottom">
                <div class="row justify-content-center ">
                    <div class="col-md-12">
                        <!-- <h3 class="text-white">Dashboard</h3>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb bg-light p-3 rounded">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav> -->
                        <Breadcrumb></Breadcrumb>
                    </div>
                </div>
            </header>
            
            <main class="row justify-content-center mb-3">
                <div class="col-md-12 mb-3">
                    <Alert :show="alert.show" :type="alert.type" :message="alert.message" @alertClosed="resetAlert()" />
                </div>
                <div class="col-md-12 mb-3">
                    <router-view/>
                </div>
            </main>
        </div>

        <Footer/>
    </div>
</template>

<script>
    import DashboardNavigation  from "./DashboardNavigation.vue";
    import Breadcrumb from "../components/Breadcrumb.vue";
    import Footer from "./Footer.vue";
    import { authState } from '.././store/authState.js';

    export default {
        components: {
            DashboardNavigation,
            Breadcrumb,
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
            // Notify to user if session has expired, triggered by 401 unauthorize request 
            this.$event.on('session-inactive', (e) => {
                let message = e.message;
                this.alert = {
                    show: true,
                    type: "error",
                    message: message,
                };
            });

            // Display flash message from any page
            this.$event.on('flash-message', (e) => {
                let { type = "alert-info", message } = e;
                this.alert = {
                    show: true,
                    type,
                    message,
                };
            });

            // Watch the inactive session from authState data store
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
    }
</script>