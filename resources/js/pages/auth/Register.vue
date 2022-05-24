<template>
     <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <Alert :show="alert.show" :type="alert.type" :message="alert.message" @alertClosed="resetAlert()" />

                <div class="card card-default">
                    <div class="card-header bg-secondary bg-gradient border"><h4 class="text-white">Register</h4></div>
                    <div class="card-body bg-primary-soft">
                        <form @submit.prevent="register()" autocomplete="off">
                            <div class="form-group row mb-3">
                                <label for="name" class="col-sm-4 col-form-label text-md-right">Name <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" class="form-control" :class="{'is-invalid': validation.name}" v-model="form.name" @input="handleInput('name')" placeholder="Input Name" required autofocus>
                                    <div v-if="validation.name" class="invalid-feedback mt-1" >
                                        <ul class="mb-0 ps-3">
                                            <li v-for="(error, index) in validation.name">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="username" class="col-sm-4 col-form-label text-md-right">Username <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="text" name="username" id="username" class="form-control" :class="{'is-invalid': validation.username}" v-model="form.username" @input="handleInput('username')" placeholder="Input Username" required>
                                    <div v-if="validation.username" class="invalid-feedback mt-1" >
                                        <ul class="mb-0 ps-3">
                                            <li v-for="(error, index) in validation.username">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="email" name="email" id="email" class="form-control" :class="{'is-invalid': validation.email}" v-model="form.email" @input="handleInput('email')" placeholder="Input Email" required>
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
                                    <input type="password" name="password" id="password" class="form-control" :class="{'is-invalid': validation.password}" placeholder="Input Password" v-model="form.password" @input="handleInput('password')" required>
                                    <div v-if="validation.password" class="invalid-feedback mt-1" >
                                        <ul class="mb-0 ps-3">
                                            <li v-for="(error, index) in validation.password">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">Password Confirmation <span class="text-danger">*</span></label>
                                <div class="col-md-6">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Retype Your Password" v-model="form.password_confirmation" @input="handleInput('password_confirmation')" required autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <SubmitButton :class="['me-2']" :text="`${'Register'}`" :processing="isProcessing"/>
                                    <ResetButton @click="resetForm()" :processing="isProcessing"/>
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
    import { registerState } from '../.././store/registerState.js';
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
                    name: "",
                    username: "",
                    email: "",
                    password: "",
                    password_confirmation: "",
                }
            };
        },
        created() {
            if (this.getFormData != null) {
                this.form = this.getFormData;
            }
        },
        computed: { 
            ...mapState(registerState, ['setFormData', 'getFormData', 'resetFormData']),
            ...mapState(authState, ['loggedIn']),
        },
        methods: {
            async register() {
                this.isProcessing = true;

                await axios.post('/register', this.form)
                    .then(({ data }) => {
                        const { message } = data;
                        const { user } = data.data;

                        this.alert = {
                            show: true,
                            type: "success",
                            message: message,
                        };

                        this.resetFormData();
                        this.loggedIn(user);
                        setTimeout(() => {
                            this.alert.message = "Redirecting...";
                            setTimeout(() => {
                                this.$router.push({name: 'dashboard'})
                            }, 1 * 1000);
                        }, 2 * 1000);
                    }).catch(({ response: { data } }) => {
                        const { message, errors } = data;

                        this.alert = {
                            show: true,
                            type: "error",
                            message: message,
                        };

                        this.validation = errors;
                    }).finally(() => {
                        this.setFormData(this.form);
                        this.isProcessing = false;
                    });
            },
            resetForm() {
                this.isProcessing = false;
                this.validation = {};
                this.alert = {};
                this.form = {
                    name: "",
                    username: "",
                    email: "",
                    password: "",
                    password_confirmation: "",
                }

                this.resetFormData();
            },
            resetAlert() {
                this.alert = {};
            },
            handleInput(inputName) {
                switch (inputName) {
                    case 'name':
                        this.validation.name = null;
                        break;
                    case 'username':
                        this.validation.username = null;
                        break;
                    case 'email':
                        this.validation.email = null;
                        break;
                    case 'password':
                        this.validation.password = null;
                        break;
                    case 'password_confirmation':
                        this.validation.password_confirmation = null;
                        break;
                    default:
                        break;
                }
            }
        },
    }
</script>