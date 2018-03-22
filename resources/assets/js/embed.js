try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');

    require('bootstrap-colorpicker');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.moment = require('moment');

require('bootstrap-datetime-picker');

import Vue from 'vue';
import ShowSlide from './views/Slide/Show.vue';

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

import '../../../public/css/countdown.css';

window.app = new Vue({
    el: '#slidemonster',
    components: {
        'slidemonster': ShowSlide
    }
});