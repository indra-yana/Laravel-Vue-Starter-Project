<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <Alert :show="alert.show" :type="alert.type" :message="alert.message" @alertClosed="resetAlert()" />
                
                <div class="card card-default">
                    <div class="card-header bg-secondary bg-gradient border"><h4 class="text-white">Login</h4></div>
                    <div class="card-body bg-primary-soft">
                        <form @submit.prevent="doLogin()">
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
                            <div class="form-group row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="password" name="password" id="password" class="form-control" :class="{'is-invalid': validation.password}" v-model="form.password" @input="handleInput('password')" placeholder="Input Password" required autocomplete="off">
                                    <div v-if="validation.password" class="invalid-feedback mt-1" >
                                        <ul class="mb-0 ps-3">
                                            <li v-for="(error, index) in validation.password">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <div class="col-md-8 offset-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="remember" id="remember" class="form-check-input" v-model="form.remember" @input="handleInput('remember')">
                                        <label class="form-check-label" for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <SubmitButton :class="['me-2']" :text="`${'Submit'}`" :processing="isProcessing"/>
                                    <ResetButton @click="resetForm()" :processing="isProcessing"/>
                                    <router-link :to="{ name: 'password.email' }" class="btn btn-link text-lg-right">Forgot Your Password?</router-link>
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
                    password: "",
                    remember: false,
                }
            };
        },
        created() {
            
        },
        methods: {
            doLogin() {
                // Dummy actions 
                this.isProcessing = true,
                setTimeout(() => {
                    this.isProcessing = false;

                    this.alert = {
                        show: true,
                        type: "error",
                        message: "Validation failed!",
                    };

                    this.validation = {
                        email: ["The email is required.", "The email must be valid email address."],
                        password: ["The password doesn't match."],
                    };
                }, 3 * 1000);
            },
            resetForm() {
                this.isProcessing = false;
                this.validation = {};
                this.alert = {};
                this.form = {
                    email: "",
                    password: "",
                    remember: false,
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
                    case 'password':
                        this.validation.password = null;
                        break;
                    default:
                        break;
                }
            }
        },
    }
</script>