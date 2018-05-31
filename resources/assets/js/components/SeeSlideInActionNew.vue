<template>
    <div>
        <div v-if="form.layout == 3" v-show="isInAction" id="demo_content" :class="'rect spp_slideup_container '+form.background_image" :style="'border-top-width: '+form.border_width+'px; border-top-style: '+form.border_style+'; border-top-color: '+form.border_color+'; background-color: '+form.background_color+'; display: block;'">
            <i id="spp-slup-close" class="icon-remove icon-larger" @click="close"></i>
            <div class="row" id="slide_row">

                <div class="col" id="left_col">
                    <template v-if="form.left_col.length" v-for="(feature, key) in form.left_col">
                        <slide-feature :prod="prod" :form="form" :feature="feature" v-if="form.types.includes(feature)"></slide-feature>
                    </template>
                </div>
                <div class="col" id="center_col">
                    <template v-if="form.center_col.length" v-for="(feature, key) in form.center_col">
                        <slide-feature :prod="prod" :form="form" :feature="feature" v-if="form.types.includes(feature)"></slide-feature>
                    </template>
                </div>
                <div class="col" id="right_col">
                    <template v-if="form.right_col.length" v-for="(feature, key) in form.right_col">
                        <slide-feature :prod="prod" :form="form" :feature="feature" v-if="form.types.includes(feature)"></slide-feature>
                    </template>
                </div>
            </div>
        </div>

        <div v-else v-show="isInAction" id="demo_content" :class="'spp_slideup_container '+form.background_image" :style="'border-top-width: '+form.border_width+'px; border-top-style: '+form.border_style+'; border-top-color: '+form.border_color+'; background-color: '+form.background_color+'; display: block;'">
            <i id="spp-slup-close" class="icon-remove icon-larger" @click="close"></i>
            <div class="block_content" id="single_col_slide">
                <template v-for="feature in form.one_col">
                    <!-- Ad/Content & CTA Button -->
                    <template v-if="form.types.includes('adcontent')">
                        <span v-html="form.content" class="slide-feature" data-id="adcontent" v-if="feature == 'adcontent'"></span>
                        <cta-button :form="form" data-id="cta_btn" :class="`slide-feature btn ${form.button_style} ${form.button_color}  ${form.button_size}`" v-if="feature == 'cta_btn'"></cta-button>
                    </template>

                    <!-- Opt-in -->
                    <div class="spp-slup-ar slide-feature optin-col-1" v-if="form.types.includes('optin') && feature == 'optin'" data-id="optin">
                        <form :action="form.post_url" method="POST" class="">
                            <label class="add-on"><i class="icon-user"></i></label>
                            <input type="text" :name="form.name_field" class="span2" id="slup-name" :placeholder="form.name_label">
                            <label class="add-on"><i class="icon-envelope"></i></label>
                            <input type="email" :name="form.email_field" class="span2" id="slup-email" :placeholder="form.email_label">

                            <button type="submit" :class="`btn btn-block ${form.button_style} ${form.button_color}  ${form.button_size}`">
                                {{ form.button_label }}
                            </button>
                        </form>
                    </div>

                    <!-- Countdown Timer -->
                    <countdown v-if="form.types.includes('timer') && feature == 'timer'" data-id="timer" :form="form" :end-date="form.timer_end" class="slide-feature"></countdown>

                    <!-- Social Networks -->
                    <div class="spp-slup-social slide-feature" v-if="form.types.includes('social') && feature == 'social'" data-id="social">
                        <a class="icon-twitter-sign icon-larger" :href="form.twitter" v-if="!!form.twitter"></a>
                        <a class="icon-facebook-sign icon-larger" :href="form.facebook" v-if="!!form.facebook"></a>
                        <a class="icon-pinterest-sign icon-larger" :href="form.pinterest" v-if="!!form.pinterest"></a>
                        <a class="icon-linkedin-sign icon-larger" :href="form.linkedin" v-if="!!form.linkedin"></a>
                        <a class="icon-youtube-sign icon-larger" :href="form.youtube" v-if="!!form.youtube"></a>
                        <a class="icon-rss-sign icon-larger" :href="form.rss" v-if="!!form.rss"></a>
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import CTAButton from './CTAButton.vue';
    import CountdownTimer from './CountdownTimer.vue';
    import SlideFeature from './SlideFeature.vue';

    export default {
        props: ['form', 'prod', 'mode'],
        components: {
            'cta-button': CTAButton,
            'countdown': CountdownTimer,
            'slide-feature': SlideFeature
        },
        data() {
            return {
                isInAction: true,
                defaults: {
                    left_col: [],
                    center_col: ['adcontent', 'cta_btn', 'optin'],
                    right_col: ['timer'],
                    one_col: ['adcontent', 'cta_btn', 'optin', 'timer', 'social']
                }
            };
        },

        mounted() {
            // if (form.one_col.length == 0) {

            // }
            console.log(this.mode == 'create');
            if (this.$route.meta.mode != 'edit') {
                this.form.left_col = this.defaults.left_col;
                this.form.center_col = this.defaults.center_col;
                this.form.right_col = this.defaults.right_col;
                this.form.one_col = this.defaults.one_col;
            }

            Event.listen('appOnProd', (status) => {
                console.log("preventing click");

                if (status == false) {
                    // prevent click events on buttons and links
                    $(document).on('click', "#slide_row a, #slide_row button", function (e) {
                        e.preventDefault();
                        showInfoMsg("Click event has been disabled on this page.");
                    });
                }
            });

            $.getScript('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', () => {
                // Do jQueryUI things here
                let _self = this;

                $("#slide_row .slide-feature, #slide_row .col").sortable({
                    connectWith: '#slide_row .col',
                    update: () => {
                        if (_self.form.layout == 3) {
                            _self.updateLayoutChild(false);
                            console.log('saving position (3 cols)..');
                        }
                    }
                });

                $("#single_col_slide, #single_col_slide .slide-feature:not([data-id='social'])").sortable({
                    connectWith: '#single_col_slide',
                    update: () => {
                        if (_self.form.layout == 1) {
                           _self.updateLayoutChild(true);
                           console.log('saving position (one col)..');
                        }
                    }
                });

                //$(".slide-feature").sortable('destroy');
                $.each($('.slide-feature'), function (i, el) {
                    if ($(el).hasClass('ui-sortable')) {
                        $(el).sortable('destroy');
                    }
                });
            });
        },

        methods: {
            updateLayoutChild(singleColumn) {
                if (singleColumn) {
                    this.form.one_col = this.getChildren("#single_col_slide");
                } else {
                    this.form.left_col = this.getChildren("#left_col");
                    this.form.center_col = this.getChildren("#center_col");
                    this.form.right_col = this.getChildren("#right_col");
                }

                Event.fire('featurePositionsUpdated', {
                    left_col: this.form.left_col,
                    center_col: this.form.center_col,
                    right_col: this.form.right_col,
                    one_col: this.form.one_col
                });
            },

            getChildren(selector) {
                var features = [
                    'adcontent',
                    'cta_btn',
                    'optin',
                    'timer',
                    'social'
                ];
                
                var children = [];

                var el = $(selector);
                $.each(features, (i, row) => {
                    if ($(document).find(`${selector} [data-id='${row}']`).length) { // check existence
                        // get the index
                        children[$(`${selector} [data-id='${row}']`).index()] = row;
                    }
                });

                return children;
                
            },

            close() {
                try {
                    this.isInAction = false;
                    Event.fire('closeSlide');
                } catch (e) {
                    console.warn(e);
                }
            },
        }
    }
</script>