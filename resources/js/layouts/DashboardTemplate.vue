<template>
    <div class="d-flex flex-column min-vh-100">
        
        <DashboardNavigation/>

        <div class="container mt-5 mb-5 pt-5">
            <header class="mb-4 border-bottom">
                <div class="row justify-content-center ">
                    <div class="col-md-12">
                        <Breadcrumb/>
                    </div>
                </div>
            </header>
            
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
    import DashboardNavigation  from "./DashboardNavigation.vue";
    import Breadcrumb from "../components/Breadcrumb.vue";
    import Footer from "./Footer.vue";
    import Alert from "../components/Alert.vue";
    import { authState } from '.././src/store/authState.js';

    export default {
        components: {
            DashboardNavigation,
            Breadcrumb,
            Footer,
            Alert
        },
        data() {
            return {

            };
        },
        created() {
            // Watch the inactive session from authState data store
            authState().$subscribe((mutation, state) => {
                const { active, message } = state.session;
                if (!active && message) {
                    this.$event.emit('session-inactive', { 'message': message });
                }
            });
        },
        methods: {

        },
    }
</script>