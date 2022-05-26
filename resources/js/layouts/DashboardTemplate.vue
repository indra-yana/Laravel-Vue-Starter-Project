<template>
    <div>
        <DashboardNavigation/>

        <div class="container mt-5">
            <Alert :show="alert.show" :type="alert.type" :message="alert.message" @alertClosed="resetAlert()" />

            <router-view/>
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

            authState().$subscribe((mutation, state) => {
                const { active, message } = state.session;
                if (!active) {
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