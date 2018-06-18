<template>
	<div>
		<!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-primary fixed-top" color-on-scroll="200">
            <div class="container">
                <div class="dropdown button-dropdown">
                    <a href="#slide-monster" class="dropdown-toggle" id="navbarDropdown" :data-toggle="auth ? 'dropdown' : ''">
                        <span class="button-bar"></span>
                        <span class="button-bar"></span>
                        <span class="button-bar"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-header">{{ loggedUserName }}</a>
                        <router-link to="/profile" class="dropdown-item">Profile</router-link>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" @click="logout"><i class="fa fa-sign-out"></i> Logout</a>
                    </div>
                </div>
                <div class="navbar-translate">
                    <router-link to="/" class="navbar-brand" data-placement="bottom" rel="tooltip" :title="appName">{{ appName }}</router-link>
                    <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navigation" :data-nav-image="base_url+'img/blurred-image-1.jpg'">
                    <ul class="navbar-nav">
                        <li v-if="guest" class="nav-item">
                            <router-link to="/login" class="nav-link">Login</router-link>
                        </li>
                        <li v-if="guest" class="nav-item">
                            <router-link to="/register" class="nav-link">Register</router-link>
                        </li>
                        
                        <li class="nav-item"  v-if="auth">
                            <router-link to="/slides/create" class="nav-link">Add new</router-link>
                        </li>

                        <li class="nav-item" v-if="auth">
                            <router-link to="/profile" class="nav-link">Profile</router-link>
                        </li>

                        <li class="nav-item" v-if="auth && user && user.role == 1">
                            <router-link to="/users" class="nav-link">Users</router-link>
                        </li>

                        <li class="nav-item" v-if="auth && user && user.role == 1">
                            <router-link to="/subscription-plans" class="nav-link">Subscriptions</router-link>
                        </li>

                        <li class="nav-item" v-if="auth">
                            <a class="nav-link" @click="logout"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
	    
		<div class="wrapper">
            <div class="section" v-if="flash.error != null || flash.success != null">
                <div class="container">
                    <div class="alert alert-success" role="alert" v-if="flash.success">
                        <div class="alert-icon">
                            <i class="now-ui-icons ui-2_like"></i>
                        </div>
                        <strong>Well done!</strong> {{flash.success}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">
                                <i class="now-ui-icons ui-1_simple-remove"></i>
                            </span>
                        </button>
                    </div>

                    <div class="alert alert-danger" role="alert" v-if="flash.error">
                        <div class="alert-icon">
                            <i class="now-ui-icons objects_support-17"></i>
                        </div>
                        <strong>Oh snap!</strong> {{flash.error}}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">
                                <i class="now-ui-icons ui-1_simple-remove"></i>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            

            <router-view></router-view>
		</div>
		
	</div>
</template>

<script type="text/javascript">
	import Auth from './store/auth';
	import Flash from './helpers/flash';
    import { get, post, interceptors } from './helpers/api';
	import { handleErrorResponse, showErrorMsg, userUsesIE } from './helpers/helper';

    import Vue from 'vue';
    import VueResource from 'vue-resource';

    Vue.use(VueResource);

	export default {
        data() {
            return {
                authState: Auth.state,
                flash: Flash.state,
                loggedUserName: '',
                appName: window.app_name,
                base_url: window.base_url,
                user: null
            }
        },
		created() {
			console.log("base_url: "+window.base_url);

			Auth.initialize();

            Vue.http.headers.common['Authorization'] = `Bearer ${Auth.state.api_token}`;
			
            Event.listen('page-loaded', (pageClass) => {
                this.getUser();
            });
		},
		computed: {
			auth() {
				if(this.authState.api_token) {
					this.loggedUserName = this.authState.user_name
					return true
				}
				return false
			},
			guest() {
				return !this.auth
			}
		},
		methods: {
            getUser() {
                if (this.auth) {
                    get(`${this.base_url}api/users/${this.authState.user_id}`).then((res) => {
                        this.user = res.data;
                        Event.fire('userLoaded', this.user);
                    }, (err) => {
                        this.user = null;
                    });
                }
            },
			logout() {
				post(this.base_url+'api/logout').then((res) => {
			        if(res.data.done) {
			            // remove token
			            Auth.remove()
			            Flash.setSuccess('You have successfully logged out.');
			            this.$router.push('/login');
                        Event.fire('page-loaded', 'login-page');
			        }
			    }, (err) => {
                    console.warn(err);
                    handleErrorResponse(err.response.status);
                });
			}
		}
	}
</script>

