<template>
    <div class="slide-form-wrapper">
        <div class="container">
            <form class="form-inner-wrapper" @submit.prevent="submitForm" novalidate>
                <div class="section">
                    <h5 class="title">
                        {{ action }}
                        <router-link to="/" class="btn btn-neutral btn-warning pull-right">
                            <i class="fa fa-caret-left"></i> Back
                        </router-link>
                    </h5>
                </div>
                <div class="section">
                    <div class="row" style="padding-bottom: 5%; margin-bottom: 5%;">
                        <div class="col-md-4 bordered-right">
                            <div :class="errorClass('title')">
                                <label>Name</label>
                                <input type="text" v-model="form.title" class="form-control" placeholder="Title">
                            </div>

                            <div class="form-group">
                                <label>Slide Layout</label>
                                <select class="form-control" v-model="form.layout" @change="slideLayoutChanged">
                                    <option value="1">1 Column</option>
                                    <option value="3">3 Columns</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Type</label>
                                <!-- <select v-model="form.type" class="form-control">
                                    <option v-for="(type, key) in types" :key="key" :value="key">{{ type }}</option>
                                </select> -->
                                <div :class="errorClass('type')" v-for="(type, key) in types" :key="key">
                                    <input type="checkbox"  :id="'_'+type.id" :value="type.id" v-model="form.types" @change="formTypesChanged">
                                    <label :for="'_'+type.id">{{ type.value }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Border Width (px) </label>
                                <input type="number" v-model="form.border_width" class="form-control" placeholder="Border width">
                            </div>
                            <div class="form-group">
                                <label>Border Style</label>
                                <select class="form-control" v-model="form.border_style">
                                    <option disabled>Border Style</option>
                                    <option v-for="(borderStyle, key) in borderStyles" :key="key" :value="key">
                                        {{ borderStyle }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Border Color </label>
                                <div class="input-group colorpicker-component">
                                    <input type="text" class="form-control" placeholder="Border color" id="border_color" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>
                                    Choose a background color, Or choose a background image...
                                </label>
                                <div class="input-group colorpicker-component">
                                    <input type="text" class="form-control" placeholder="Background color" id="background_color" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                                <div>
                                    <a :class="'btn btn-simple '+key" href="javascript:void(0)" @click="form.background_image=key"
                                        v-for="(backgroundImage, key) in backgroundImages" :key="key">
                                        <i class="fa fa-check" v-if="form.background_image == key"></i>
                                        {{ backgroundImage }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group pull-right">
                                <button type="submit" class="btn btn-primary" :disabled="isProcessing">
                                    <i class="fa fa-refresh fa-spin" v-if="isProcessing"></i>
                                    <i class="fa fa-check" v-if="!isProcessing"></i> {{ action }}
                                </button>
                                <button type="button" class="btn btn-info" @click="isInAction = !isInAction">
                                    <span v-if="!isInAction">
                                        <i class="fa fa-eye"></i> See it in action
                                    </span>
                                    <span v-if="isInAction">
                                        <i class="fa fa-close"></i> Stop rendering
                                    </span>
                                </button>
                                <!-- <span v-show="isInAction">
                                    Demo mode
                                    <input type="checkbox" id="is_in_demo" class="bootstrap-switch"
                                        data-on-label="ON"
                                        data-off-label="OFF" v-model="isInDemo"/>
                                </span> -->
                            </div>

                            <!-- BUTTON STYLING -->
                            <div v-if="typeof(form.types) != 'undefined' && (form.types.includes('adcontent') || form.types.includes('optin'))">
                                <legend>
                                    <i class="fa fa-caret-down i-collapse" title="Collapse"></i>
                                    Button styling
                                </legend>
                                <div class="form-group">
                                    <label>Submit Button Color</label><br/>
                                    <button-colors :form="form" class="btns-container"></button-colors>
                                </div>

                                <div class="form-group">
                                    <label>Button Style</label><br/>
                                    <button-styles :form="form" class="btns-container"></button-styles>
                                </div>

                                <div class="form-group">
                                    <label>Button Size</label><br/>
                                    <button-sizes :form="form" class="btns-container"></button-sizes>
                                </div>
                            </div>

                            <!-- AD/CONTENT & CTA BUTTON -->
                            <div v-show="typeof(form.types) != 'undefined' && form.types.includes('adcontent')">
                                <hr>
                                <legend>
                                    <i class="fa fa-caret-down i-collapse" title="Collapse"></i>
                                    Ad/Content &amp; CTA Button
                                </legend>
                                <div class="form-group">
                                    <label>Content</label>
                                    <textarea v-model="form.content" class="form-control" id="slide_content" placeholder="Add your content..."></textarea>
                                </div>

                                <!-- <div class="form-group">
                                    <label for="has_cta_button">Set Call-to-action button</label>
                                    <input type="checkbox" id="has_cta_button" v-model="form.has_cta_button">
                                </div> -->
                                <!-- <div class="form-group" v-show="form.has_cta_button"> -->
                                <div class="form-group" v-show="form.types.includes('cta_btn')">
                                    <label>CTA button text</label>
                                    <input type="text" class="form-control" v-model="form.cta_button_text">
                                </div>

                                <div class="form-group" v-show="form.types.includes('cta_btn')">
                                    <label>CTA button URL</label>
                                    <input type="text" class="form-control" v-model="form.cta_button_url">
                                </div>
                            </div>
                            <!-- END AD/CONTENT -->

                            <!-- SOCIAL MEDIA LINKS -->
                            <div class="" v-show="typeof(form.types) != 'undefined' && form.types.includes('social')">
                                <hr>
                                <legend>
                                    <i class="fa fa-caret-down i-collapse" title="Collapse"></i>
                                    Social
                                </legend>
                                <small class="help">Enter your social profile URL. Leave empty to disable.</small>

                                <div class="form-group">
                                    <label>Twitter</label>
                                    <input type="url" class="form-control" v-model="form.twitter">
                                </div>

                                <div class="form-group">
                                    <label>Facebook</label>
                                    <input type="url" class="form-control" v-model="form.facebook">
                                </div>

                                <div class="form-group">
                                    <label>Pinterest</label>
                                    <input type="url" class="form-control" v-model="form.pinterest">
                                </div>

                                <div class="form-group">
                                    <label>LinkedIn</label>
                                    <input type="url" class="form-control" v-model="form.linkedin">
                                </div>

                                <div class="form-group">
                                    <label>Youtube</label>
                                    <input type="url" class="form-control" v-model="form.youtube">
                                </div>

                                <div class="form-group">
                                    <label>RSS</label>
                                    <input type="url" class="form-control" v-model="form.rss">
                                </div>
                            </div>
                            <!-- END SOCIAL MEDIA -->

                            <!-- OPT-IN FORM -->
                            <div class="" v-show="typeof(form.types) != 'undefined' && form.types.includes('optin')">
                                <hr>
                                <legend>
                                    <i class="fa fa-caret-down i-collapse" title="Collapse"></i>
                                    Optin
                                </legend>

                                <div class="form-group">
                                    <label>Paste Your Autoresponder Code</label>
                                    <textarea class="form-control" v-model="form.autoresponder_code" placeholder="Paste Your Autoresponder Code"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Name Field</label>
                                    <input type="text" class="form-control" v-model="form.name_field" placeholder="Name Field">
                                </div>
                                <div class="form-group">
                                    <label>Email Field</label>
                                    <input type="text" class="form-control" v-model="form.email_field" placeholder="Email Field">
                                </div>
                                <div class="form-group">
                                    <label>AR Post URL</label>
                                    <input type="url" class="form-control" v-model="form.post_url" placeholder="AR Post URL">
                                </div>
                                <div class="form-group">
                                    <label>Hidden Fields</label>
                                    <textarea class="form-control" v-model="form.hidden_fields" placeholder="Hidden Fields"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Name Field Label</label>
                                    <div class="col">
                                        <input type="text" class="form-control" v-model="form.name_label" placeholder="Name Field Label">
                                        <small class="help-text">Text that appears in the name field</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Email Field Label</label>
                                    <div class="col">
                                        <input type="text" class="form-control" v-model="form.email_label" placeholder="Email Field Label">
                                        <small class="help-text">Text that appears in the email field</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Button Label</label>
                                    <div class="col">
                                        <input type="text" class="form-control" v-model="form.button_label" placeholder="Button Label">
                                        <small class="help-text">Text that appears in the button</small>
                                    </div>
                                </div>
                            </div>
                            <!-- END OPT-IN -->

                            <!-- TIMER -->
                            <div class="" v-show="typeof(form.types) != 'undefined' && form.types.includes('timer')">
                                <hr>
                                <legend>
                                    <i class="fa fa-caret-down i-collapse" title="Collapse"></i>
                                    Countdown Timer
                                </legend>
                                <div class="form-group">
                                    <label>Type</label>
                                    <select v-model="form.timer_type" class="form-control">
                                        <!-- <option v-for="(type, key) in timerTypes" :value="type" :key="key" v-text="type"></option> -->
                                        <option value="evergreen" selected>Evergreen</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="dtp_input1" class="col-md-2 control-label">End Date</label>
                                    <div class="input-group date form_datetime" :data-date="form.timer_end | formattedDate" data-link-field="dtp_input1">
                                        <span class="input-group-addon">
                                            <span class="fa fa-calendar"></span>&nbsp;&nbsp;
                                        </span>
                                        <input class="form-control" size="16" type="text" :value="form.timer_end | formattedDate" readonly>
                                        <span class="input-group-addon" @click="form.timer_end = null">
                                            &nbsp;&nbsp;<span class="fa fa-remove"></span>
                                        </span>
                                    </div>
                                    <input type="hidden" id="dtp_input1" v-model="form.timer_end" /><br/>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 br-green">
                                        <strong>Digit Font Settings</strong>
                                        <!-- <div class="form-group">
                                            <label data-toggle="tooltip" data-original-title="Size will be adjusted on smaller devices">Base Font Size (px)</label>
                                            <input type="number" v-model="form.timer_digit_size" class="form-control">
                                        </div> -->
                                        <div class="form-group">
                                            <label>Font Color</label>
                                            <input type="text" id="timer_digit_color" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <strong>Text Shadow</strong>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Color</label>
                                                    <input type="text" id="timer_digit_text_shadow_color" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Blur (px)</label>
                                                    <input type="number" v-model="form.timer_digit_text_shadow_blur" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>X offset (px)</label>
                                                    <input type="number" v-model="form.timer_digit_text_shadow_x" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Y offset (px)</label>
                                                    <input type="number" v-model="form.timer_digit_text_shadow_y" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Label Font Settings</strong>
                                        <!-- <div class="form-group">
                                            <label data-toggle="tooltip" data-original-title="Size will be adjusted on smaller devices">Base Font Size (px)</label>
                                            <input type="number" v-model="form.timer_label_size" class="form-control">
                                        </div> -->
                                        <div class="form-group">
                                            <label>Font Color</label>
                                            <input type="text" id="timer_label_color" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <strong>Text Shadow</strong>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Color</label>
                                                    <input type="text" id="timer_label_text_shadow_color" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Blur (px)</label>
                                                    <input type="number" v-model="form.timer_label_text_shadow_blur" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>X offset (px)</label>
                                                    <input type="number" v-model="form.timer_label_text_shadow_x" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Y offset (px)</label>
                                                    <input type="number" v-model="form.timer_label_text_shadow_y" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section" v-if="isInAction"></div>
            </form>
        </div>

        <div v-if="isInAction">
            <see-slide-in-action :form="form" prod="false" :mode="$route.meta.mode"></see-slide-in-action>
        </div>
    </div>
</template>

<style lang='scss'>
    .form-inner-wrapper .form-group:last {
        margin-bottom: 40px;
    }
</style>

<script>
    import {get, post} from '../../helpers/api';
    import {showErrorMsg, handleErrorResponse, handleResponse, showInfoMsg} from '../../helpers/helper';
    import SeeSlideInAction from '../../components/SeeSlideInActionNew.vue';
    import ButtonSizes from '../../components/ButtonSizes.vue';
    import ButtonStyles from '../../components/ButtonStyles.vue';
    import ButtonColors from '../../components/ButtonColors.vue';

    export default {
        components: {
            'see-slide-in-action': SeeSlideInAction,
            'button-sizes': ButtonSizes,
            'button-styles': ButtonStyles,
            'button-colors': ButtonColors
        },
        data() {
            return {
                base_url: window.base_url,
                initializeURL: `${base_url}api/slides/create`,
                storeURL: `${base_url}api/slides`,
                action: 'Create',
                pageClass: 'page-index',
                form: {
                    types: []
                },
                currentTypes: [],
                errors: {},
                isProcessing: false,
                isInAction: true,
                types: [
                    {id: 'adcontent', value: 'Ad/Content'},
                    {id: 'cta_btn', value: 'Call to action button'},
                    {id: 'timer', value: 'Timer'}
                ],
                types: [],
                borderStyles: {
                    'none': "None",
                    'solid': "Solid",
                    'dashed': "Dashed",
                    'dotted': "Dotted"
                },
                backgroundImages: {
                    "none": "None",
                    "gold_scale": "Gold Scale",
                    "light_wool": "Light Wool",
                    "paper_2": "Paper 2",
                    "paper_3": "Paper 3",
                    "ps_neutral": "PS Neutral",
                    "tweed": "Tweed"
                },
                timerTypes: [
                    'evergreen',
                    // 'default'
                ],
                date: new Date(),
                dtpConfig: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                }
            };
        },

        mounted() {
            if(this.$route.meta.mode === 'edit') {
                this.initializeURL = base_url+`api/slides/${this.$route.params.id}/edit`
                this.storeURL = base_url+`api/slides/${this.$route.params.id}?_method=PUT`
                this.action = 'Update';
            }

            this.previewUrl = `/slides/${this.$route.params.id}`;

            this.init();

            var _this = this;

            Event.listen('closeSlide', () => {
                this.isInAction = false;
            });

            Event.listen('userLoaded', (user) => {
                if (!!user && user.perms) {
                    this.types = user.perms;
                }
            });

            Event.listen('slideLayoutChanged', () => {
                Event.fire('closeSlide');
                let self = this;
                setTimeout(function() {
                    self.isInAction = true;
                }, 100);
            });

            Event.listen('featurePositionsUpdated', (form) => {
                setTimeout(function() {
                    this.form.left_col = form.left_col;
                    this.form.center_col = form.center_col;
                    this.form.right_col = form.right_col;
                    this.form.one_col = form.one_col;
                }, 2000);
            });

            /* collapsable */
            $(document).on("click", ".i-collapse", function () {
                var $this = $(this);
                if ($this.hasClass('fa-caret-down')) {
                    $this.parent('legend').siblings('div').slideUp('slow', function () {
                        $this.attr("class", "fa fa-caret-right i-collapse").attr("title", "Expand");
                    });
                } else {
                    $this.parent('legend').siblings('div').slideDown('slow', function () {
                        $this.attr("class", "fa fa-caret-down i-collapse").attr("title", "Collapse");
                    });
                }
            });

            this.form.has_timer = this.form.hasOwnProperty('types') && this.form.types.includes('timer');
                    
            $(".form_datetime").datetimepicker({
                format: "MM dd yyyy, H:i:s",
                startDate: new Date(),
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1,
                pickerPosition: 'top-right',
                fontAwesome: true
            }).on('changeDate', function(ev){
                console.log(ev.date);
                // _this.form.timer_end = ev.date.valueOf();
                _this.form.timer_end = ev.date;
                Event.fire('timerEndHasChanged', _this.form.timer_end);
            });
        },

        filters: {
            formattedDate(dateString) {
                return !dateString ? '' : moment(new Date(dateString)).format('LLL');  
            }
        },

        methods: {
            init() {
                Event.fire('page-loaded', this.pageClass);

                get(this.initializeURL).then((res) => {
                    this.form = res.data;
                    this.currentTypes = res.data.types;
                    this.initNiceEdit();
                    this.initColorPickers();

                    Event.fire('formHasLoaded', this.form);
                }, (err) => {
                    handleErrorResponse(err.response.status);
                });

                Event.fire('appOnProd', false);
            },

            initColorPickers() {
                let _this = this;

                $("#background_color").colorpicker({
                    format: 'hex',
                    enableHex8: true,
                    color: _this.form.background_color
                }).on('changeColor', function (event) {
                    _this.form.background_color = event.color.toHex();
                });

                $("#border_color").colorpicker({
                    format: 'hex',
                    enableHex8: true,
                    color: _this.form.border_color
                }).on('changeColor', function (event) {
                    _this.form.border_color = event.color.toHex();
                });

                $("#timer_label_color").colorpicker({
                    format: 'hex',
                    enableHex8: true,
                    color: _this.form.timer_label_color
                }).on('changeColor', function (event) {
                    _this.form.timer_label_color = event.color.toHex();
                    
                    var data = {id: 'timer_label_color', value: _this.form.timer_label_color};
                    Event.fire('colorPickerChanged', data);
                });

                $("#timer_label_text_shadow_color").colorpicker({
                    format: 'hex',
                    enableHex8: true,
                    color: _this.form.timer_label_text_shadow_color
                }).on('changeColor', function (event) {
                    _this.form.timer_label_text_shadow_color = event.color.toHex();

                    var data = {id: 'timer_label_text_shadow_color', value: _this.form.timer_label_text_shadow_color};
                    Event.fire('colorPickerChanged', data);
                });

                $("#timer_digit_color").colorpicker({
                    format: 'hex',
                    enableHex8: true,
                    color: _this.form.timer_digit_color
                }).on('changeColor', function (event) {
                    _this.form.timer_digit_color = event.color.toHex();

                    var data = {id: 'timer_digit_color', value: _this.form.timer_digit_color};
                    Event.fire('colorPickerChanged', data);
                });

                $("#timer_digit_text_shadow_color").colorpicker({
                    format: 'hex',
                    enableHex8: true,
                    color: _this.form.timer_digit_text_shadow_color
                }).on('changeColor', function (event) {
                    _this.form.timer_digit_text_shadow_color = event.color.toHex();

                    var data = {id: 'timer_digit_text_shadow_color', value: _this.form.timer_digit_text_shadow_color};
                    Event.fire('colorPickerChanged', data);
                });
            },

            initNiceEdit() {
                // this.checkDemoState();
                let _this = this;

                $.getScript( window.app_url+"/plugins/nicedit/nicEdit-latest.js", ( data, textStatus, jqxhr ) => {
                    var slideContent = new nicEditor().panelInstance('slide_content');
                    nicEditors.findEditor( "slide_content" ).setContent(_this.form.content);
                    

                    $("div.nicEdit-main").bind('keyup', function () {
                        _this.form.content = $(this).html();
                    });

                    slideContent.addEvent('blur', () => {
                        _this.form.content = $("div.nicEdit-main").html();
                    });

                    slideContent.addEvent("focus", () => {
                        _this.form.content = $("div.nicEdit-main").html();
                    });


                    // fix width
                    $('.nicEdit-panelContain').parents('div:first').css('width', '100%');
                    $('.nicEdit-main').css('width', '100%').css('minHeight', '54px')
                        .parents('div:first').css('width', '100%').css('minHeight', '54px');

                });
            },

            hasError(field) {
                return this.errors.hasOwnProperty(field);
            },
            errorClass(field) {
                var defaultClass = 'form-group';
                return this.hasError(field) ? defaultClass+' has-danger' : defaultClass;
            },

            submitForm() {
                this.isProcessing = true;

                this.updateLayoutChild(this.form.layout);

                post(this.storeURL, this.form).then((res) => {
                    handleResponse(res.data);
                    this.$router.push('/');
                }, (err) => {
                    console.log(err);
                    handleErrorResponse(err.response.status);
                    if (err.response.status == 422) {
                        this.errors = err.response.data.errors;
                    }
                }).then(() => {
                    this.isProcessing = false;
                });
            },

            addOrRemove(key) {
                console.log(key);
            },

            slideLayoutChanged() {
                Event.fire('slideLayoutChanged');
            },

            updateLayoutChild(layout) {
                if (layout == 1) {
                    this.form.one_col = this.getChildren("#single_col_slide");
                } else {

                    this.form.left_col = this.getChildren("#left_col");
                    this.form.center_col = this.getChildren("#center_col");
                    this.form.right_col = this.getChildren("#right_col");
                }

                console.log("newChildren:");
                console.log({
                    "left": this.form.left_col,
                    "center": this.form.center_col,
                    "right": this.form.right_col
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
                    if ($(document).find(`${selector} [data-id='${row}']`).length && $(document).find(`${selector} [data-id='${row}']`).is(":visible")) { // check existence
                        // get the index
                        children[$(`${selector} [data-id='${row}']`).index()] = row;
                    }
                });

                return children;
                
            },

            formTypesChanged() {
                Event.fire('formTypesChanged');
            }
        }
    }
</script>