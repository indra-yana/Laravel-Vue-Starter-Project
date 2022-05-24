<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <Alert :show="alert.show" :type="alert.type" :message="alert.message" @alertClosed="resetAlert()" />

                <div class="card card-default">
                    <div class="card-header bg-secondary bg-gradient border"><h4 class="text-white">Verify</h4></div>
                    <div class="card-body bg-primary-soft">
                        <form @submit.prevent="routeName === 'verification.verify' ? verify() : sendVerificationLink()">
                            <div v-if="routeName === 'verification.verify'">
                                <div class="row mb-3">
                                    <div class="col-sm-12 col-form-label text-md-right">
                                        <h5>Please Click the button bellow to verify your account.</h5>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-12 text-center">
                                        <SubmitButton :text="`${'Verify'}`" :processing="isProcessing"/>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="row mb-3">
                                    <div class="col-sm-12 col-form-label text-md-right">
                                        <h5>Before proceeding, please check your email for a verification link.</h5>
                                        <p>If you did not receive the email, click the action bellow.</p>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <SubmitButton :class="['me-2']" :text="`${'Resend verification link'}`" :processing="isProcessing" />
                                        <!-- <router-link :to="{ name: 'login'}" class="btn btn-link text-lg-right">Back to login</router-link> -->
                                        <button type="button" class="btn btn-link text-lg-right" :disabled="isProcessing" @click="checkIfHasVerified()">
                                           Check if has verified
                                        </button>
                                    </div>
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
    import { mapState } from 'pinia'
    import { authState } from '../.././store/authState.js';
    
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
                routeName: this.$route.name,
                verifyData: {
                    id: this.$route.params.id,
                    hash: this.$route.params.hash,
                    expires: this.$route.query.expires,
                    signature: this.$route.query.signature,
                },
            };
        },
        created() {
            // console.log(this.$route.name, this.$route.params, this.$route.query);
            this.checkIfHasVerified();
        },
        mounted() {
        },
        computed: { 
            ...mapState(authState, ['hasVerifiedEmail']),
        },
        methods: {
            async sendVerificationLink() {
                this.isProcessing = true;

                await this.$axios.post('/email/resend', this.form)
                    .then(({ data }) => {
                        const { message } = data;
                        const { hasVerifiedEmail, email_verified_at = null } = data.data;

                        this.alert = {
                            show: true,
                            type: "success",
                            message: message,
                        };

                        if (hasVerifiedEmail) {
                            this.hasVerifiedEmail(email_verified_at);
                            setTimeout(() => {
                                this.alert.message = "Redirecting...";
                                setTimeout(() => {
                                    this.$router.push({name: 'dashboard'})
                                }, 1 * 1000);
                            }, 2 * 1000);
                        }
                    }).catch(({ response: { data } }) => {
                        const { message, errors } = data;

                        this.alert = {
                            show: true,
                            type: "error",
                            message: message,
                        };

                        this.validation = errors;
                    }).finally(() => {
                        this.isProcessing = false;
                    });
            },
            async verify() {
                this.isProcessing = true;
                const { id, hash, expires, signature } = this.verifyData;
                console.log(this.verifyData);

                await this.$axios.get(`/email/verify/${id}/${hash}?expires=${expires}&signature=${signature}`)
                    .then(({ data }) => {
                        const { message } = data;
                        const { hasVerifiedEmail, email_verified_at = null } = data.data;

                        this.alert = {
                            show: true,
                            type: "success",
                            message: message,
                        };

                        if (hasVerifiedEmail) {
                            this.hasVerifiedEmail(email_verified_at);
                            setTimeout(() => {
                                this.alert.message = "Redirecting...";
                                setTimeout(() => {
                                    this.$router.push({name: 'dashboard'})
                                }, 1 * 1000);
                            }, 2 * 1000);
                        }
                    }).catch(({ response: { data } }) => {
                        const { message, errors } = data;

                        this.alert = {
                            show: true,
                            type: "error",
                            message: message,
                        };

                        this.validation = errors;
                    }).finally(() => {
                        this.isProcessing = false;
                    });
            },
            async checkIfHasVerified() {
                this.isProcessing = true;

                await this.$axios.get('/checkIfHasVerified')
                    .then(({ data }) => {
                        const { message } = data;
                        const { hasVerifiedEmail, email_verified_at = null } = data.data;

                        this.alert = {
                            show: true,
                            type: "success",
                            message: message,
                        };

                        if (hasVerifiedEmail) {
                            this.hasVerifiedEmail(email_verified_at);
                            setTimeout(() => {
                                this.alert.message = "Redirecting...";
                                setTimeout(() => {
                                    this.$router.push({name: 'dashboard'})
                                }, 1 * 1000);
                            }, 2 * 1000);
                        }
                    }).catch(({ response: { data } }) => {
                        const { message, errors } = data;

                        this.alert = {
                            show: true,
                            type: "error",
                            message: message,
                        };

                        this.validation = errors;
                    }).finally(() => {
                        this.isProcessing = false;
                    });
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