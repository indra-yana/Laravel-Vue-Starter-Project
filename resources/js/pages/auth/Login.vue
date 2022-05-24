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
                                <label for="identity" class="col-sm-4 col-form-label text-md-right">E-Mail Address / Username<span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" name="identity" id="identity" class="form-control" :class="{'is-invalid': validation.identity}" v-model="form.identity" @input="handleInput('identity')" placeholder="Input Email / Username" required autofocus autocomplete="off" >
                                    <div v-if="validation.identity" class="invalid-feedback mt-1" >
                                        <ul class="mb-0 ps-3">
                                            <li v-for="(error, index) in validation.identity">{{ error }}</li>
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
                form: {
                    identity: "",
                    password: "",
                    remember: false,
                }
            };
        },
        created() {
            
        },
        computed: { 
            ...mapState(authState, ['loggedIn'])
        },
        methods: {
            async doLogin() {
                this.isProcessing = true;

                await this.$axios.get('/sanctum/csrf-cookie');
                await this.$axios.post('/login', this.form)
                    .then(({ data }) => {
                        const { message } = data;
                        const { user } = data.data;

                        this.alert = {
                            show: true,
                            type: "success",
                            message: message,
                        };

                        this.loggedIn(user);
                        setTimeout(() => {
                            this.alert.message = "Redirecting...";
                            setTimeout(() => {
                                this.$router.push({name: 'dashboard'})
                            }, 1 * 1000);
                        }, 2 * 1000);

                        /*
                        axios.get("/api/user")
                            .then(({ data }) => {
                                this.alert = {
                                    show: true,
                                    type: "success",
                                    message: "Loggin successfully!",
                                };

                                this.loggedIn(data);
                                this.$router.push({name: 'dashboard'})

                                return data;
                            })
                            .catch(({ response: { data } }) => {
                                return data;
                            });
                        */
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
                this.form = {
                    identity: "",
                    password: "",
                    remember: false,
                }
            },
            resetAlert() {
                this.alert = {};
            },
            handleInput(inputName) {
                switch (inputName) {
                    case 'identity':
                        this.validation.identity = null;
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