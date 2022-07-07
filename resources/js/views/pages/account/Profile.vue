<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-light rounded w-100">
                <div class="card-header bg-secondary bg-gradient border">
                    <NavAccount/>
                </div>
                <div class="card-body bg-primary-soft">

                    <!-- <Spinner :processing='isProcessing'/> -->

                    <form @submit.prevent="update()" autocomplete="off">
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
                                <input type="email" name="email" id="email" class="form-control" :class="{'is-invalid': validation.email}" v-model="form.email" @input="handleInput('email')" placeholder="Input Email" required readonly>
                                <div v-if="validation.email" class="invalid-feedback mt-1" >
                                    <ul class="mb-0 ps-3">
                                        <li v-for="(error, index) in validation.email">{{ error }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">
                            <label for="avatar" class="col-form-label text-md-right">Avatar </label>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="align-items-center">
                                        <div class="mb-3">
                                            <img class="img-fluid rounded-circle border border-1 border-secondary" id="img-preview" style="width: 90px; height: 90px;" :src="form.previewAvatar" src="/images/user.png" alt="Avatar">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group my-3">
                                    <input type="file" name="avatar" id="avatar" class="form-control" :class="{'is-invalid': validation.avatar}" @change="handleInput('avatar', $event)" ref="file" accept="image/*">
                                    <div v-if="validation.avatar" class="invalid-feedback mt-1" >
                                        <ul class="mb-0 ps-3">
                                            <li v-for="(error, index) in validation.avatar">{{ error }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <SubmitButton :class="['me-2']" :text="`${'Update'}`" :processing="isProcessing"/>
                                <ResetButton @click="resetForm()" :processing="isProcessing"/>
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
    import Spinner from '@components/Spinner.vue';
    import { mapState } from 'pinia'
    import { authState } from '@src/store/authState.js';
    import AuthService from '@src/services/AuthService.js';

    export default {
        components: { NavAccount, Spinner },
        data() {
            return {
                isProcessing: false,
                routeName: this.$route.meta.title,
                isProcessing: false,
                validation: {},
                defaultAvatar: "/images/user.png",
                originalValue: {},
                form: {
                    name: "",
                    username: "",
                    email: "",
                    avatar: "",
                    previewAvatar: "/images/user.png",
                },
                authService: new AuthService(),
            }
        },
        created() {
            this.$event.emit('breadcrumbs', { 
                title: this.routeName, 
                breadcrumbs: {
                    'account': 'Account',
                    '#': this.routeName,
                } 
            });

            if (!this.auth.user) {
                this.getUser();
            } else {
                this.updateFormValue(this.auth.user);
            }
        },
        computed: { 
            ...mapState(authState, ['loggedIn', 'auth']),
        },
        methods: {
            async getUser() {
                this.isProcessing = true;

                const result = await this.authService.user(this.form);
                const { success, failure } = result;

                if (success) {
                    const user = success.data;
                    this.updateFormValue(user);
                }
                    
                if (failure) {
                    const { message, errors = {} } = failure;

                    this.$event.emit('flash-message', { message, type: "error", withToast: true });
                }

                this.isProcessing = false;
            },
            async update() {
                this.isProcessing = true;
                this.validation = {};

                const formData = new FormData();
                formData.append('_method', 'PUT');

                for (const item in this.form) {
                    formData.append(item, this.form[item]);
                }

                const result = await this.authService.update(formData);
                const { success, failure } = result;

                if (success) {
                    const { message } = success;
                    const user = success.data;

                    this.resetForm();
                    this.updateFormValue(user);
                    this.loggedIn(user);

                    this.$event.emit('flash-message', { message, type: "success", withToast: true });
                }

                if (failure) {
                    const { message, errors = {} } = failure;

                    this.validation = errors;
                    this.$event.emit('flash-message', { message, type: "error", withToast: true });
                }

                this.isProcessing = false;
            },
            resetForm() {
                this.isProcessing = false;
                this.validation = {};
                this.updateFormValue(this.originalValue);
    
                document.getElementById("avatar").value = "";
            },
            updateFormValue(data) {
                const { name, username, email, avatar } = data;

                this.form.name = name; 
                this.form.username = username; 
                this.form.email = email;
                this.form.previewAvatar = avatar || this.defaultAvatar;

                // Set original value
                this.originalValue = data;
                this.originalValue.previewAvatar = data.avatar || this.defaultAvatar;
            },
            handleInput(inputName, event = null) {
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
                    case 'avatar':
                        this.validation.avatar = null;
                        this.form.avatar = event.target.files[0];   // or this.$refs.file.files.item(0);
                        this.form.previewAvatar = URL.createObjectURL(this.form.avatar);
                        break;
                    default:
                        break;
                }
            }
        }
    }
</script>