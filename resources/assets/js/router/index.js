import Vue from 'vue';
import VueRouter from 'vue-router';

import Auth from '../store/auth';


import Login from '../views/Auth/Login.vue';
import Register from '../views/Auth/Register.vue';
import NotFound from '../views/NotFound.vue';
import Profile from '../views/Profile.vue';
import SlideForm from '../views/Slide/Form.vue';
import SlideIndex from '../views/Slide/Index.vue';
import Users from '../views/Admin/Users.vue';
import Subscriptions from '../views/Admin/Subscriptions.vue';
import Upgrades from '../views/Upgrades.vue';

Vue.use(VueRouter);

const router = new VueRouter({
	mode: 'history',
	base: window.base_url,
	routes: [
		{ path: '/slides/create', component: SlideForm, meta: { mode: 'create' } },
		{ path: '/slides/:id/edit', component: SlideForm, meta: { mode: 'edit' } },
		{ path: '/slides/:id' },
		{ path: '/users', component: Users },
		{ path: '/subscription-plans', component: Subscriptions },
		{ path: '/', component: SlideIndex },
		{ path: '/register', component: Register },
		{ path: '/login', component: Login },
		{ path: '/profile', component: Profile },
		{ path: '/subscribe', component: Upgrades },
		{ path: '/not-found', component: NotFound },
		{ path: '*', component: NotFound },
	]
});

export default router;
