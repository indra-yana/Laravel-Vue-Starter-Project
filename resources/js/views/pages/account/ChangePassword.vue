<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-light rounded w-100">
                <div class="card-header bg-secondary bg-gradient border">
                    <NavAccount/>
                </div>
                <div class="card-body bg-primary-soft">
                    <form @submit.prevent="changePassword()" autocomplete="off">
                        <div class="form-group row mb-3">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right">Current Password <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="password" name="current_password" id="current_password" class="form-control" :class="{'is-invalid': validation.current_password}" placeholder="Your Current Password" v-model="form.current_password" @input="handleInput('current_password')" required>
                                <div v-if="validation.current_password" class="invalid-feedback mt-1" >
                                    <ul class="mb-0 ps-3">
                                        <li v-for="(error, index) in validation.current_password">{{ error }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="password" name="password" id="password" class="form-control" :class="{'is-invalid': validation.password}" placeholder="Input New Password" v-model="form.password" @input="handleInput('password')" required>
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
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Retype Your New Password" v-model="form.password_confirmation" @input="handleInput('password_confirmation')" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <SubmitButton :class="['me-2']" :text="`${'Change Password'}`" :processing="isProcessing"/>
                                <ResetButton :class="['me-2']" @click="resetForm()" :processing="isProcessing"/>
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
    import NavAccount from '@components/NavAccount.vue';
    
    export default {
        components: { NavAccount },
        data() {
            return {
                routeName: this.$route.meta.title,
                isProcessing: false,
                validation: {},
                form: {
                    current_password: '',
                    password: "",
                    password_confirmation: "",
                }
            };
        },
        created() {
            this.$event.emit("breadcrumbs", {
                title: this.routeName,
                breadcrumbs: {
                    "account": "Account",
                    "#": this.routeName,
                }
            });
        },
        methods: {
            async changePassword() {
                this.isProcessing = true;
                this.validation = {};

                await this.$axios.put('/api/v1/user/password/change', this.form)
                    .then(({ data }) => {
                        const { message } = data;

                        this.$event.emit('flash-message', { message, type: "success", withToast: true });
                        this.resetForm();
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
                this.form.current_password = "";
                this.form.password = "";
                this.form.password_confirmation = "";
            },
            handleInput(inputName) {
                switch (inputName) {
                    case 'current_password':
                        this.validation.current_password = null;
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