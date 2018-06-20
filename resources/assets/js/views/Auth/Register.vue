<template>
    <div class="wrapper">
        <div class="page-header" filter-color="orange">
            <div class="page-header-image" :style="'background-image:url('+this.$router.options.base+'img/bg3.jpg)'"></div>
            <div class="container">
                <div class="col-md-4 content-center">
                    <div class="card card-login card-plain">
                        <form class="form-horizontal" @submit.prevent="register" style="margin-top: 84px;">
                            <div class="header header-primary text-center">
                                <div class="logo-container">
                                    <img :src="this.$router.options.base+'images/logo.png'">
                                    <h5>Register</h5>
                                </div>
                            </div>
                            <div class="content">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user-circle"></i>
                                        </span>
                                        <input id="name" type="text" placeholder="Name" class="form-control"  v-model="form.name">
                                    </div>
                                    <small class="error__control" v-if="error.name">{{error.name[0]}}</small>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-envelope"></i>
                                        </span>
                                        <input id="email" type="email" placeholder="Email" class="form-control"  v-model="form.email">
                                    </div>
                                    <small class="error__control" v-if="error.email">{{error.email[0]}}</small>
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                        <input id="password" placeholder="Password" type="password" class="form-control"  v-model="form.password">
                                    </div>
                                    <small class="error__control" v-if="error.password">{{error.password[0]}}</small>
                                    
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                        <input id="password_confirmation" placeholder="Confirm Password" type="password" class="form-control"  v-model="form.password_confirmation">
                                    </div>
                                </div>
                            </div>
                            <div class="footer text-center">
                                    <button :disabled="isProcessing" class="btn btn-primary btn-round btn-lg btn-block">
                                        <i class="fa fa-check" v-if="!isProcessing"></i>
                                        <i class="fa fa-refresh fa-spin" v-if="isProcessing"></i>
                                        Register
                                    </button>
                            </div>
                            <div class="pull-left">
                                <h6>
                                    <router-link to="/login" class="link" data-toggle="tooltip" data-placement="top" title="Login">Already a member?</router-link>
                                </h6>
                            </div>
                            <div class="pull-right">
                                <h6>
                                    <a class="link" href="password/reset" data-toggle="tooltip" data-placement="top" title="Password Reset">
                                        Forgot Your Password?
                                    </a>
                                </h6>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import Flash from '../../helpers/flash';
    import { post } from '../../helpers/api';
    import {handleErrorResponse} from '../../helpers/helper';
    import Auth from '../../store/auth';

    export default {
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },
                error: {},
                isProcessing: false,
                pageClass: 'login-page'
            }
        },
        mounted() {
            if (Auth.state.api_token) {
                this.$router.push('/');
            }
            Event.fire('page-loaded', this.pageClass)
        },
        methods: {
            register() {
                this.isProcessing = true
                this.error = {}
                post(this.$router.options.base+'api/register', this.form).then((res) => {
                    if(res.data.registered) {
                        Flash.setSuccess('Congratulations! You have now successfully registered. Please login to get started.')
                        this.$router.push('/login')
                    }
                    this.isProcessing = false
                }, (err) => {
                    handleErrorResponse(err.response.status);
                    if(err.response.status === 422) {
                        this.error = err.response.data.errors;
                    }
                    this.isProcessing = false
                });
            }
        }
    }
</script>
