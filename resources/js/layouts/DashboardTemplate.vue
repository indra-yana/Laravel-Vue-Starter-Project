<template>
    <div>
        <DashboardNavigation/>

        <div class="container mt-5 mb-5">
            <header class="mb-5 border-bottom">
                <div class="row justify-content-center ">
                    <div class="col-md-12">
                        <h3 class="text-white">Dashboard</h3>
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb bg-light p-3 rounded">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </nav>
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
  </div>
</template>

<script>
    import DashboardNavigation  from "./DashboardNavigation.vue";
    import { authState } from '.././store/authState.js';

    export default {
        components: {
            DashboardNavigation,
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
    }
</script>