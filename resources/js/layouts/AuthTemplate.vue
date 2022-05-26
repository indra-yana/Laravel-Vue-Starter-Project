<template>
  <div>
      <MainNavigation />

      <div class="container mt-5">
        <div class="row justify-content-center">
          <div class="col-md-8">
              <Alert :show="alert.show" :type="alert.type" :message="alert.message" @alertClosed="resetAlert()" />
          </div>
        </div>

        <router-view/>
      </div>
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