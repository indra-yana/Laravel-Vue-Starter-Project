<template>
    <div class="d-flex flex-column min-vh-100">

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
    import MainNavigation from './MainNavigation.vue'
    import Footer from './Footer.vue';
    import Alert from '../components/Alert.vue';
    import { authState } from '.././store/authState.js';
  
    export default {
        components: {
            MainNavigation,
            Footer,
            Alert
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