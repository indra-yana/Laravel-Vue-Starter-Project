<template>
    <div class="d-flex flex-column min-vh-100">

        <Loader/>

        <MainNavigation/>

        <div class="container mt-5 mb-5 pt-5">
            <main class="row justify-content-center mb-3">
                <div class="col-md-12 mb-3">
                    <Alert/>
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
    import MainNavigation from '@layouts/MainNavigation.vue'
    import Footer from '@layouts/Footer.vue';
    import Alert from '@components/Alert.vue';
    import Loader from "@components/Loader.vue";
    import { authState } from '@src/store/authState.js';
  
    export default {
        components: {
            MainNavigation,
            Footer,
            Alert,
            Loader,
        },
        data() {
            return {
                
            };
        },
        created() {
            authState().$subscribe((mutation, state) => {
                const { active, message } = state.session;
                if (!active && message) {
                    this.$event.emit('session-inactive', { 'message': message });
                }
            });
        },
        methods: {

        },  
    };
</script>