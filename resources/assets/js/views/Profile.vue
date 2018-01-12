<template>
    <div>
        <div class="page-header page-header-small" filter-color="orange">
            <div class="page-header-image" data-parallax="true" :style="'background-image:url('+this.$router.options.base+'img/bg5.jpg)'">
            </div>
            <div class="container">
                <div class="content-center">
                    <div class="photo-container">
                        <img :src="this.$router.options.base+'img/default-avatar.png'" :alt="form.name">
                    </div>
                    <h3 class="title" v-text="form.name"></h3>
                    <p class="category" v-text="form.email"></p>
                    <div class="content">
                        <div class="social-description">
                            <h2>26</h2>
                            <p>Ad/Content </p>
                        </div>
                        <div class="social-description">
                            <h2>26</h2>
                            <p>Opt-in</p>
                        </div>
                        <div class="social-description">
                            <h2>48</h2>
                            <p>Social</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-md col-md-offset-4">
                        <form @submit.prevent="update">

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" type="text" class="form-control"  v-model="form.name">
                                <small class="error__control" v-if="error.name">{{error.name[0]}}</small>
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input id="email" type="email" class="form-control"  v-model="form.email" readonly>
                                <small class="error__control" v-if="error.email">{{error.email[0]}}</small>
                            </div>

                            <div class="form-group">
                                <label for="license_key">License key</label>
                                <input type="license_key" class="form-control" v-model="form.license_key">
                                <small class="error__control" v-if="error.license_key">{{error.license_key[0]}}</small>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control"  v-model="form.password" placeholder="Leave empty to keep current password.">
                                <small class="error__control" v-if="error.password">{{error.password[0]}}</small>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input id="password_confirmation" type="password" class="form-control"  v-model="form.password_confirmation" placeholder="Leave empty to keep current password.">
                            </div>

                            <div class="form-group">
                                <button :disabled="isProcessing" class="btn btn-primary pull-right">
                                    <i class="fa fa-check" v-if="!isProcessing"></i>
                                    <i class="fa fa-refresh fa-spin" v-if="isProcessing"></i> Update 
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue'
    import Flash from '../helpers/flash'
    import Auth from '../store/auth'
    import { get, post } from '../helpers/api'
    import { scrollToTop, handleErrorResponse } from '../helpers/helper'

    export default {
        data() {
            return {
                isProcessing: false,
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    license_key: ''
                },
                error: {},
                isProcessing: false,
                initializeURL: this.$router.options.base+`api/profile?api_token=${Auth.state.api_token}`,
                pageClass: 'profile-page'
            }
        },
        mounted() {
            Event.fire('page-loaded', this.pageClass);

            this.init();
        },
        methods: {
            init() {
                get(this.initializeURL).then((res) => {
                    Vue.set(this.$data, 'form', res.data.form);
                }, (err) => {
                    handleErrorResponse(err.response.status);
                });
            },
            update() {
                this.isProcessing = true;
                post(this.initializeURL, this.form).then((res) => {
                    if(res.data.success) {
                        Flash.setSuccess(res.data.message);
                        localStorage.setItem('user_name', this.form.name);
                        this.$router.app.$emit('profile-updated');
                        this.error = {};
                        scrollToTop();
                    }
                    this.isProcessing = false
                }, (err) => {
                    if(err.response.status === 422) {
                        this.error = err.response.data.errors
                        Flash.setError(err.response.data.message)
                        scrollToTop();
                    }
                    this.isProcessing = false
                });
            }
        }
    }
</script>