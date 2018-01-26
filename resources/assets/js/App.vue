<template>
	<div>
		<nprogress-container></nprogress-container>

		<!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-primary fixed-top">
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

                        <li class="nav-item" v-if="auth">
                            <a class="nav-link" @click="logout"><i class="fa fa-sign-out"></i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
	    
		<div class="wrapper">
            <div class="section">
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
    import { post, interceptors } from './helpers/api';
	import { handleErrorResponse, showErrorMsg } from './helpers/helper';
	import NProgress from 'vue-nprogress';
	import NprogressContainer from 'vue-nprogress/src/NprogressContainer';

    const nprogress = new NProgress();

	export default {
		nprogress,
		created() {
			console.log("base_url: "+window.base_url);
			// global error http handler
			interceptors((err) => {
				nprogress.done();
				if(err.response.status === 401) {
					Auth.remove()
					this.$router.push('/login')
				}

				if(err.response.status === 500) {
					Flash.setError(err.response.statusText)
				}

				if(err.response.status === 404) {
					this.$router.push('/not-found')
				}
			});

			axios.interceptors.request.use((config) => {
	            nprogress.start();
	            return config;
	        }, function (error) {
	            return Promise.reject(error);
	        });
	        
	        axios.interceptors.response.use((response) => {
	            nprogress.done();
	            return response;
	        }, function (error) {
	            return Promise.reject(error);
	        });

			Auth.initialize();
			// this.$router.app.$on('profile-update', () => {
			// 	console.log('listening profile-update this.$router...');
			// 	this.loggedUserName = localStorage.getItem('user_name');
			// });

			// Event.listen('profile-update', () => {
			// 	console.log('listening profile-update this...');
			// 	this.loggedUserName = localStorage.getItem('user_name');
			// });
		},
		data() {
			return {
				authState: Auth.state,
				flash: Flash.state,
				loggedUserName: '',
				appName: window.app_name,
				base_url: window.base_url
			}
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
		},
		components: {
			NprogressContainer
		}
	}
</script>

