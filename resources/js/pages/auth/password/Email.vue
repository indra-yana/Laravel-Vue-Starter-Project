<template>
    <div class="">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <Alert :show="alert.show" :type="alert.type" :message="alert.message" @alertClosed="resetAlert()"/>

                <div class="card card-default">
                    <div class="card-header bg-secondary bg-gradient border"><h4 class="text-white">Forgot Password</h4></div>
                    <div class="card-body bg-primary-soft">
                        <form @submit.prevent="sendResetLink()">
                            <div class="form-group row mb-3">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="email" name="email" id="email" class="form-control" :class="{'is-invalid': validation.email}" v-model="form.email" @input="handleInput('email')" placeholder="Input Email" required autofocus autocomplete="off" >
                                    <div v-if="validation.email" class="invalid-feedback mt-1" >
                                        <ul class="mb-0 ps-3">
                                            <li v-for="(error, index) in validation.email">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <SubmitButton :class="['me-2']" :text="`${'Send Password Reset Link'}`" :processing="isProcessing"/>
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
                form: {
                    email: "",
                }
            };
        },
        created() {
            
        },
        methods: {
            async sendResetLink() {
                this.isProcessing = true,
                
                await this.$axios.post('/password/email', this.form)
                    .then(({ data }) => {
                        const { message } = data;

                        this.alert = {
                            show: true,
                            type: "success",
                            message: message,
                        };
                    }).catch(({ response: { data } }) => {
                        const { message, errors = {} } = data;

                        this.validation = errors;
                        this.alert = {
                            show: true,
                            type: "error",
                            message: message,
                        };
                    }).finally(() => {
                        this.isProcessing = false;
                    });
            },
            resetForm() {
                this.isProcessing = false;
                this.validation = {};
                this.alert = {};
                this.form = {
                    email: "",
                }
            },
            resetAlert() {
                this.alert = {};
            },
            handleInput(inputName) {
                switch (inputName) {
                    case 'email':
                        this.validation.email = null;
                        break;
                    default:
                        break;
                }
            }
        },
    }
</script>