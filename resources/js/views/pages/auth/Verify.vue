<template>
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                                    <p class="m-0">If you did not receive the email, click the action <cite>Resend verification</cite> bellow.</p>
                                    <p>Or if you have already verify your account, please check it by click <cite>Check if has verified</cite>.</p>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <SubmitButton :class="['me-2']" :text="`${'Resend verification link'}`" :processing="isProcessing" />
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
</template>

<script>
    import { mapState } from 'pinia'
    import { authState } from '@src/store/authState.js';
    
    export default {
        data() {
            return {
                isProcessing: false,
                validation: {},
                routeName: this.$route.name,
                verifyUrl: this.$route.query.verify_url,
            };
        },
        created() {
            this.checkIfHasVerified();
        },
        computed: { 
            ...mapState(authState, ['hasVerifiedEmail']),
        },
        methods: {
            async sendVerificationLink() {
                this.resetForm();
                this.isProcessing = true;

                await this.$axios.post('/email/resend', this.form)
                    .then(({ data }) => {
                        const { message } = data;
                        const { hasVerifiedEmail, email_verified_at = null } = data.data;

                        this.$event.emit('flash-message', { message, type: "success", withToast: true });

                        if (hasVerifiedEmail) {
                            this.hasVerifiedEmail(email_verified_at);
                            setTimeout(() => {
                                this.$event.emit('flash-message', { message: "Redirecting...", type: "info" });
                                setTimeout(() => {
                                    this.$router.push({name: 'dashboard'})
                                }, 1 * 1000);
                            }, 2 * 1000);
                        }
                    }).catch(({ response: { data } }) => {
                        const { message, errors = {} } = data;

                        this.validation = errors;
                        this.$event.emit('flash-message', { message, type: "error", withToast: true });
                    }).finally(() => {
                        this.isProcessing = false;
                    });
            },
            async verify() {
                this.resetForm();
                this.isProcessing = true;

                await this.$axios.get(this.verifyUrl)
                    .then(({ data }) => {
                        const { message } = data;
                        const { hasVerifiedEmail, email_verified_at = null } = data.data;

                        this.$event.emit('flash-message', { message, type: "success", withToast: true });

                        if (hasVerifiedEmail) {
                            this.hasVerifiedEmail(email_verified_at);
                            setTimeout(() => {
                                this.$event.emit('flash-message', { message: "Redirecting...", type: "info" });
                                setTimeout(() => {
                                    this.$router.push({name: 'dashboard'})
                                }, 1 * 1000);
                            }, 2 * 1000);
                        }
                    }).catch(({ response: { data } }) => {
                        const { message, errors = {} } = data;

                        this.validation = errors;
                        this.$event.emit('flash-message', { message, type: "error", withToast: true });
                    }).finally(() => {
                        this.isProcessing = false;
                    });
            },
            async checkIfHasVerified() {
                this.resetForm();
                this.isProcessing = true;

                await this.$axios.get('/checkIfHasVerified')
                    .then(({ data }) => {
                        const { message } = data;
                        const { hasVerifiedEmail, email_verified_at = null } = data.data;

                        this.$event.emit('flash-message', { message, type: "success", withToast: true });

                        if (hasVerifiedEmail) {
                            this.hasVerifiedEmail(email_verified_at);
                            setTimeout(() => {
                                this.$event.emit('flash-message', { message: "Redirecting...", type: "info" });
                                setTimeout(() => {
                                    this.$router.push({name: 'dashboard'})
                                }, 1 * 1000);
                            }, 2 * 1000);
                        }
                    }).catch(({ response: { data } }) => {
                        const { message, errors = {} } = data;

                        this.validation = errors;
                        this.$event.emit('flash-message', { message, type: "error", withToast: true });
                    }).finally(() => {
                        this.isProcessing = false;
                    });
            },
            resetForm() {
                this.isProcessing = false;
                this.validation = {};
            },
        },
    }
</script>