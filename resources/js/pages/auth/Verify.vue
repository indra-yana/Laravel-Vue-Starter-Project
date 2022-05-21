<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <Alert :show="alert.show" :type="alert.type" :message="alert.message" @alertClosed="resetAlert()" />

                <div class="card card-default">
                    <div class="card-header bg-secondary bg-gradient border"><h4 class="text-white">Verify</h4></div>
                    <div class="card-body bg-primary-soft">
                        <form @submit.prevent="sendVerificationLink()">
                            <div class="row mb-3">
                                <div class="col-sm-12 col-form-label text-md-right">
                                    <h5>Before proceeding, please check your email for a verification link.</h5>
                                    <p>If you did not receive the email, click the action bellow.</p>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <SubmitButton :class="['me-2']" :text="`${'Resend verification link'}`" :processing="isProcessing"/>
                                    <router-link :to="{ name: 'login'}" class="btn btn-link text-lg-right">Back to login</router-link>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                isProcessing: false,
                validation: {},
                alert: {
                    show: false,
                    type: "",
                    message: "",
                },
            };
        },
        created() {
            
        },
        methods: {
            sendVerificationLink() {
                // Dummy actions 
                this.isProcessing = true,
                setTimeout(() => {
                    this.isProcessing = false;

                    this.alert = {
                        show: true,
                        type: "success",
                        message: "Please check your email for verification link!",
                    };
                }, 3 * 1000);
            },
            resetForm() {
                this.isProcessing = false;
                this.validation = {};
                this.alert = {};
            },
            resetAlert() {
                this.alert = {};
            },
        },
    }
</script>