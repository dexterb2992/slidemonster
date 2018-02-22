require('./bootstrap');

import Vue from 'vue';

import App from './App.vue';
import router from './router';

require('./helpers/toast.min.js');



const base_url = window.base_url;

window.Event =  new class {
    constructor() {
        this.vue = new Vue();
    }

    fire(event, data = null) {
        this.vue.$emit(event, data);
    }

    listen(event, callback) {
        this.vue.$on(event, callback);
    }
};


window.app = new Vue({
    el: '#root',
    template: `<app></app>`,
    components: { App },
    router,
    created() {
        Event.listen('profile-updated', () => {
            this.profileUpdatedListener();
        });

        Event.listen('page-loaded', (pageClass) => {
            this.pageLoadedListener(pageClass);
        });

        this.init();
    },

    methods: {
        init() {
            $('[data-toggle="tooltip"]').tooltip();

            let $navbar = $('.navbar[color-on-scroll]');
            let scroll_distance = $navbar.attr('color-on-scroll') || 500;

            // Check if we have the class "navbar-color-on-scroll" then add the function to remove the class "navbar-transparent" so it will transform to a plain color.

            if ($('.navbar[color-on-scroll]').length != 0) {
                nowuiKit.checkScrollForTransparentNavbar();
                $(window).on('scroll', nowuiKit.checkScrollForTransparentNavbar);
            }
        },
        pageLoadedListener(pageClass) {
            if (pageClass == 'login-page' || pageClass == 'profile-page') {
                $('.navbar').addClass("navbar-transparent")
                    .attr('color-on-scroll', 300);
            } else {
                $('.navbar').removeClass("navbar-transparent")
                    .removeAttr('color-on-scroll');
            }

            $('body').attr("class", "sidebar-collapse "+pageClass);
        },
        profileUpdatedListener() {
            $children[0].loggedUserName = localStorage.getItem('user_name');
        }
    }
});