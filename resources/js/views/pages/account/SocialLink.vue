<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card bg-light rounded ">
                <div class="card-header bg-secondary bg-gradient border">
                    <NavAccount/>
                </div>
                <div class="card-body bg-primary-soft">
                    
                    <!-- <Spinner :processing='isProcessing'/> -->

                    <form @submit.prevent="updateSocialLink()" autocomplete="off">
                        <div class="form-group row mb-3" v-for="(socials, key, index) in form.social_links">
                            <label :for="key" class="col-sm-4 col-form-label text-md-right">{{ key }} <span class="text-danger">*</span></label>
                            <div class="col-md-6">
                                <input type="text" :name="key" :id="key" class="form-control" :class="{'is-invalid': validation[key]}" v-model="form.social_links[key]['link']" @input="handleInput(key)" :placeholder="`Add your ${key} link`">
                                <div v-if="validation[key]" class="invalid-feedback mt-1" >
                                    <ul class="mb-0 ps-3">
                                        <li v-for="(error, index) in validation[key]">{{ error }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <SubmitButton :class="['me-2']" :text="`${'Submit'}`" :processing="isProcessing"/>
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
    import { mapState } from 'pinia';
    import { authState } from '@src/store/authState.js';
    import { socialLinkState } from '@src/store/socialLinkState.js';
    import SocialLinkService from '@src/services/SocialLinkService.js';

    export default {
        components: { NavAccount, Spinner },
        data() {
            return {
                isProcessing: false,
                routeName: this.$route.meta.title,
                isProcessing: false,
                validation: {},
                originalValue: {},
                form: {
                    social_links: {},
                },
                socialLinkService: new SocialLinkService(),
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

            if (!this.socialLinks) {
                this.getSocialink();
            } else {
                this.updateFormValue(this.socialLinks);
            }
        },
        computed: {
            ...mapState(authState, ['auth']),
            ...mapState(socialLinkState, ['socialLinks', 'setSocialLinks']),
            getValidation() {
                return this.validation;
            }
        },
        methods: {
            async getSocialink() {
                this.isProcessing = true;

                const result = await this.socialLinkService.show(this.auth.user.id);
                const { success, failure } = result;

                if (success) {
                    const { social_links: socialLinks } = success.data;

                    this.updateFormValue(socialLinks);
                    this.setSocialLinks(socialLinks);
                }
                    
                if (failure) {
                    const { message, errors = {} } = failure;

                    this.$event.emit('flash-message', { message, type: "error", withToast: true });
                }

                this.isProcessing = false;
            },
            async updateSocialLink() {
                this.isProcessing = true;
                this.validation = {};

                const result = await this.socialLinkService.create(this.form);
                const { success, failure } = result;

                if (success) {
                    const { message } = success;
                    const { social_links: socialLinks } = success.data;

                    this.updateFormValue(socialLinks);
                    this.setSocialLinks(socialLinks);

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
                this.updateFormValue(this.originalValue.social_links);
            },
            updateFormValue(data) {
                this.form.social_links = JSON.parse(JSON.stringify(data));  // Convert proxy data to an object

                // Set original value
                this.originalValue.social_links = JSON.parse(JSON.stringify(data));
            },
            handleInput(inputName, event = null) {
                this.validation[inputName] = null;
            },
        },
    }
</script>
