<template>
    <div class="row justify-content-center">
        <div class="col-md-8">

            <Alert :show="alert.show" :type="alert.type" :message="alert.message" v-on:alertClosed="resetAlert()" />

            <div class="card card-default">
                <div class="card-header bg-secondary bg-gradient border"><h4 class="text-white">Confirm Password</h4></div>
                <div class="card-body bg-primary-soft">
                    <form @submit.prevent="confirmPassword()" autocomplete="off">
                        <div class="row mb-3">
                            <div class="col-sm-12 col-form-label text-md-right">
                                <h5>Please confirm your password before continuing.</h5>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="password" name="password" id="password" class="form-control" :class="{'is-invalid': validation.password}" placeholder="Input Password" v-model="form.password" @input="handleInput('password')" required autocomplete="current-password">
                                <div v-if="validation.password" class="invalid-feedback mt-1" >
                                    <ul class="mb-0 ps-3">
                                        <li v-for="(error, index) in validation.password">{{ error }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <SubmitButton :class="['me-2']" :text="`${'Confirm Password'}`" :processing="isProcessing"/>
                                <router-link :to="{ name: 'password.request' }" class="btn btn-link text-lg-right">Forgot Your Password?</router-link>
                            </div>
                        </div>
                    </form>
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
                    password: "",
                }
            };
        },
        created() {

        },
        methods: {
            confirmPassword() {
                // Dummy actions 
                this.isProcessing = true,
                setTimeout(() => {
                    this.isProcessing = false;

                    this.alert = {
                        show: true,
                        type: "success",
                        message: "Your password is confirmed!",
                    };
                }, 3 * 1000);
            },
            resetForm() {
                this.isProcessing = false;
                this.validation = {};
                this.alert = {};
                this.form = {
                    password: "",
                }
            },
            resetAlert() {
                this.alert = {};
            },
            handleInput(inputName) {
                switch (inputName) {
                    case 'password':
                        this.validation.password = null;
                    default:
                        break;
                }
            }
        },
    }
</script>