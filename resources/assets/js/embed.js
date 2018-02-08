require('./bootstrap');

import Vue from 'vue';
import ShowSlide from './views/Slide/Show.vue';


window.app = new Vue({
    el: '#slidemonster',
    components: {
        'slidemonster': ShowSlide
    }
});