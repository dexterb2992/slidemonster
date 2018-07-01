<template>
    <div>
        <div v-if="form.layout == 3" v-show="isInAction" id="demo_content" :class="'rect spp_slideup_container '+form.background_image" :style="'border-top-width: '+form.border_width+'px; border-top-style: '+form.border_style+'; border-top-color: '+form.border_color+'; background-color: '+form.background_color+'; display: block;'">
            <div class="row">
                <div class="col-md-12" style="position: absolute;">
                    <i id="spp-slup-close" class="icon-remove icon-larger pull-right" @click="close"></i>
                </div>
            </div>
            <div class="row" id="slide_row">
                <div class="col-md-4 slidemonster-col" id="left_col">
                    <template v-for="(feature, key) in newColumnChildren.left_col">
                        <slide-feature :prod="prod" :form="form" :feature="feature"
                            v-if="(getPosition(feature) == 'left')">
                        </slide-feature>
                    </template>
                </div>

                <div class="col-md-4 slidemonster-col" id="center_col">
                    <template v-for="(feature, key) in newColumnChildren.center_col">
                        <slide-feature :prod="prod" :form="form" :feature="feature"
                            v-if="(getPosition(feature) == 'center')">
                        </slide-feature>
                    </template>
                </div>

                <div class="col-md-4 slidemonster-col" id="right_col">
                    <template v-for="(feature, key) in newColumnChildren.right_col">
                        <slide-feature :prod="prod" :form="form" :feature="feature"
                            v-if="(getPosition(feature) == 'right')">
                        </slide-feature>
                    </template>
                </div>
            </div>
        </div>

        <div v-else v-show="isInAction" id="demo_content" :class="'spp_slideup_container '+form.background_image" :style="'border-top-width: '+form.border_width+'px; border-top-style: '+form.border_style+'; border-top-color: '+form.border_color+'; background-color: '+form.background_color+'; display: block;'">
            <div class="row">
                <div class="col-md-12" style="position: absolute;height: 2px;">
                    <i id="spp-slup-close" class="icon-remove icon-larger pull-right" @click="close"></i>
                </div>
            </div>
            <div class="block_content" id="single_col_slide">
                <template v-for="feature in form.one_col">
                    <!-- Ad/Content & CTA Button -->
                    <template v-if="form.types.includes('adcontent')">
                        <span v-html="form.content" class="slide-feature" data-id="adcontent" v-if="feature == 'adcontent'"></span>
                        <cta-button :form="form" data-id="cta_btn" :class="`slide-feature btn ${form.button_style} ${form.button_color}  ${form.button_size}`" v-if="feature == 'cta_btn'"></cta-button>
                    </template>

                    <!-- Opt-in -->
                    <div class="spp-slup-ar slide-feature optin-col-1" v-if="form.types.includes('optin') && feature == 'optin'" data-id="optin">
                        <form :action="form.post_url" method="POST" class="optin-col-1">
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

<style lang="scss">
    .slidemonster-col {
        padding-top: 8px;
        padding-bottom: 8px;
    }
    div.slide-feature {
        padding-bottom: 4px;
        padding-top: 4px;
    }
</style>

<script>
    import CTAButton from './CTAButton.vue';
    import CountdownTimer from './CountdownTimer.vue';
    import SlideFeature from './SlideFeature.vue';
    import {showWarningMsg} from '../helpers/helper';

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
                    left_col: ['adcontent', 'cta_btn'],
                    center_col: ['optin', 'social'],
                    right_col: ['timer'],
                    one_col: ['adcontent', 'cta_btn', 'optin', 'timer', 'social']
                },
                newColumnChildren: {
                    left_col: [],
                    center_col: [],
                    right_col: [],
                    one_col: []
                }
            };
        },

        mounted() {
            if (this.mode == 'create') {
                console.log("this.mode: "+this.mode);
                this.form.left_col = this.defaults.left_col;
                this.form.center_col = this.defaults.center_col;
                this.form.right_col = this.defaults.right_col;
                this.form.one_col = this.defaults.one_col;
            }

            if (typeof(this.form.left_col) != 'undefined') {
                this.newColumnChildren.one_col = this.form.one_col;

                this.newColumnChildren.left_col = this.form.left_col;
                this.newColumnChildren.center_col = this.form.center_col;
                this.newColumnChildren.right_col = this.form.right_col;

            }

            Event.listen('appOnProd', (status) => {
                console.log("preventing click");

                if (status == false) {
                    // prevent click events on buttons and links
                    $(document).on('click', "#slide_row a, #slide_row button", function (e) {
                        e.preventDefault();
                        showWarningMsg("This action has been disabled on this page.");
                    });

                    $(document).on('submit', "#slide_row form", function (e) {
                        e.preventDefault();
                        showWarningMsg("This action has been disabled on this page.");
                    });
                }
            });

            Event.listen('slideLayoutChanged', () => {
                // Do jQueryUI things here
                let _self = this;

                console.log("yeah, I'm listening to slideLayoutChanged event");
            });

            Event.listen('formHasLoaded', (form) => {
                this.newColumnChildren.left_col = form.left_col;
                this.newColumnChildren.center_col = form.center_col;
                this.newColumnChildren.right_col = form.right_col;
            });

            Event.listen('formTypesChanged', () => {
                $.each(this.form.types, (i, type) => {
                    if (this.form.layout == 3) {
                        if (!this.newColumnChildren.left_col.includes(type) && this.getPosition(type) == 'left') {
                            this.newColumnChildren.left_col.push(type);
                        }

                        if (!this.newColumnChildren.center_col.includes(type) && this.getPosition(type) == 'center') {
                            this.newColumnChildren.center_col.push(type);
                        }

                        if (!this.newColumnChildren.right_col.includes(type) && this.getPosition(type) == 'right') {
                            this.newColumnChildren.right_col.push(type);
                        }
                    } else {
                        if (!this.form.one_col.includes(type)) {
                            this.form.one_col.push(type);
                        }
                    }
                });
            });

            if (this.prod != 'true') {
                $.getScript('https://code.jquery.com/ui/1.12.1/jquery-ui.min.js', () => {
                    // Do jQueryUI things here
                    let _self = this;

                    $(".slidemonster-col").sortable({
                        connectWith: ".slidemonster-col"
                    });

                    $("#single_col_slide").sortable({
                        connectWith: '#single_col_slide'
                    });

                    if ($('.slide-feature').hasClass('ui-sortable')) {
                        $('.slide-feature').sortable('destroy');
                    }

                    if ($(".slide-feature[data-id='social']").hasClass("ui-sortable")) {
                        $(".slide-feature[data-id='social]").sortable("destroy");
                    }
                });
            }
        },

        methods: {
            setNewColumnChildren(value) {
                this.newColumnChildren = value;
            },

            close() {
                try {
                    this.isInAction = false;
                    Event.fire('closeSlide');
                } catch (e) {
                    console.warn(e);
                }
            },

            getPosition(feature) {
                /*defaults: {
                    left_col: [],
                    center_col: ['adcontent', 'cta_btn', 'optin'],
                    right_col: ['timer'],
                    one_col: ['adcontent', 'cta_btn', 'optin', 'timer', 'social']
                }*/

                let position = '';

                if (!this.form.types.includes(feature)) {
                    return 'n/a';
                }

                // check first it's default position
                if (this.defaults.left_col.includes(feature)) {
                    position = 'left';
                } else if (this.defaults.center_col.includes(feature)) {
                    position = 'center';
                } else {
                    position = 'right';
                }

                // now, let's check if its position has changed
                if (this.newColumnChildren.left_col.includes(feature)) {
                    position = 'left';
                }

                if (this.newColumnChildren.center_col.includes(feature)) {
                    position = 'center';
                }

                if (this.newColumnChildren.right_col.includes(feature)) {
                    position = 'right';
                }

                return position;
            }
        }
    }
</script>