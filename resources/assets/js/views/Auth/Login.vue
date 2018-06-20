<template>
    <div class="wrapper">
        <div class="page-header" filter-color="orange">
            <div class="page-header-image" :style="'background-image:url('+this.$router.options.base+'img/login.jpg)'"></div>
            <div class="container">
                <div class="col-md-4 content-center">
                    <div class="card card-login card-plain">
                        <form class="form" @submit.prevent="login"  style="margin-top: 84px;">
                            <div class="header header-primary text-center">
                                <div class="logo-container">
                                    <img :src="this.$router.options.base+'images/logo.png'">
                                    <h5>Login</h5>
                                </div>
                            </div>
                            <div class="content">
                                <div class="form-group-no-border">
                                    <div class="input-group input-lg">
                                        <span class="input-group-addon">
                                            <i class="fa fa-user-circle"></i>
                                        </span>
                                        <input type="email" class="form-control"  v-model="form.email" placeholder="Email">
                                    </div>
                                    <small class="error__control" v-if="error.email">{{error.email[0]}}</small>
                                </div>
                                <div class="form-group-no-border">
                                    <div class="input-group input-lg">
                                        <span class="input-group-addon">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                        <input type="password" v-model="form.password" placeholder="Password" class="form-control" />
                                    </div>
                                    <small class="error__control" v-if="error.password">{{error.password[0]}}</small>
                                </div>
                                <!-- <div class="form-group-no-border">
                                    <div class="input-group">
                                        <div class="checkbox">
                                            <input id="rememberme" name="remember" type="checkbox">
                                            <label for="rememberme">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <div class="footer text-center">
                                <button :disabled="isProcessing" class="btn btn-primary btn-round btn-lg btn-block">
                                    <i class="fa fa-sign-in" v-if="!isProcessing"></i> 
                                    <i class="fa fa-refresh fa-spin" v-if="isProcessing"></i> Login
                                </button>
                            </div>
                            <div class="pull-left">
                                <h6>
                                    <router-link to='/register' class="link" data-toggle="tooltip" data-placement="top" title="Register">Create Account</router-link>
                                </h6>
                            </div>
                            <div class="pull-right">
                                <h6>
                                    <a class="link" href="password/reset" data-toggle="tooltip" data-placement="top" title="Reset Password">
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
    import Auth from '../../store/auth';
    import { post } from '../../helpers/api';
    import {handleErrorResponse} from '../../helpers/helper';

    export default {
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                error: {},
                isProcessing: false,
                pageClass: 'login-page'
            }
        },
        mounted() {
            console.log(this.auth);
            console.log(typeof this.auth);
            if (Auth.state.api_token) {
                this.$router.push('/');
            }
            Event.fire('page-loaded', this.pageClass);
        },
        methods: {
            login() {
                this.isProcessing = true
                this.error = {}
                post(this.$router.options.base+'api/login', this.form).then((res) => {
                    if(res.data.authenticated) {
                        // set token
                        Auth.set(res.data.api_token, res.data.user_id, res.data.user_name);
                        Flash.setSuccess('You have successfully logged in.');
                        this.$router.push('/');
                    }
                    this.isProcessing = false;
                }).catch((err) => {
                    handleErrorResponse(err.response.status);
                    if(err.response.status === 422) {
                        if(err.response.data.hasOwnProperty('errors')){
                            this.error = err.response.data.errors;
                        }else{
                            this.error = err.response.data;
                        }
                    }
                    this.isProcessing = false;
                });
            }
        }
    }
</script>
