<template>
    <div class="slide-form-wrapper">
        <div class="container">
            <form class="form-inner-wrapper" @submit.prevent="saveSlide">

                <div class="section">
                    <div class="row">
                        <div class="col-md-4 bordered-right">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" v-model="form.title" class="form-control" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <label>Type</label>
                                <select v-model="form.type" class="form-control">
                                    <option v-for="(type, key) in types" :key="key" :value="key">{{ type }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Content</label>
                                <textarea v-model="form.content" class="form-control" placeholder="Add your content..."></textarea>
                            </div>

                            <div class="form-group">
                                <label>Border Width: </label>
                                <div class="input-group">
                                    <input type="number" v-model="form.border_width" class="form-control" placeholder="Border width">
                                    <div class="input-group-addon">
                                        <div class="input-group-text">px</div>
                                    </div>
                                </div>
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
                                <label>Border Color: </label>
                                <div id="border_color" class="input-group colorpicker-component">
                                    <input type="text" class="form-control" placeholder="Border color" v-model="form.border_color" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>
                                    Choose a background color, Or choose a background image...
                                </label>
                                <div id="background_color" class="input-group colorpicker-component">
                                    <input type="text" class="form-control" placeholder="Background color" v-model="form.background_color" />
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
                                    <i class="fa fa-check" v-if="!isProcessing"></i> Create
                                </button>
                                <button type="button" class="btn btn-info" @click="isInAction = !isInAction">
                                    <span v-if="!isInAction">
                                        <i class="fa fa-eye"></i> See it in action
                                    </span>
                                    <span v-if="isInAction">
                                        <i class="fa fa-close"></i> Stop rendering
                                    </span>
                                </button>
                                <span v-if="isInAction">
                                    Demo mode
                                    <input type="checkbox" id="is_in_demo" class="bootstrap-switch"
                                        data-on-label="ON"
                                        data-off-label="OFF" v-model="isInDemo"/>
                                </span>
                            </div>

                            <div class="" v-if="form.type == 'optin'">
                                <legend>Optin</legend>

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

                                <div class="form-group">
                                    <label>Submit Button Color</label><br/>
                                    <span v-for="(buttonColor, key) in buttonColors" :key="key" class="col-md-8">
                                        <a :class="'btn '+buttonColor" @click="form.button_color = buttonColor" href="javascript:void(0)">
                                           <i class="fa fa-check" v-if="form.button_color == buttonColor"></i> {{ key }}
                                        </a>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label>Button Style</label><br/>
                                    <span v-for="(buttonStyle, key) in buttonStyles" :key="key" class="col">
                                        <a :class="'btn '+form.button_color+' '+buttonStyle" @click="form.button_style = buttonStyle"  href="javascript:void(0)">
                                            <i class="fa fa-check" v-if="form.button_style == buttonStyle"></i> {{ key }}
                                        </a>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label>Button Size</label><br/>
                                    <span v-for="(buttonSize, key) in buttonSizes" :key="key" class="col">
                                        <a :class="'btn '+form.button_size+' '+buttonSize" @click="form.button_size = buttonSize"  href="javascript:void(0)">
                                            <i class="fa fa-check" v-if="form.button_size == buttonSize"></i> {{ key }}
                                        </a>
                                    </span>
                                </div>
                            </div>

                            <div class="" v-if="form.type == 'social'">
                                <legend>Social</legend>
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
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div v-if="isInAction" :style="isInDemo ? 'fixed !important' : 'relative !important'">
            <div id="demo_content" :class="'spp_slideup_container '+form.background_image" :style="'border-top-width: '+form.border_width+'px; border-top-style: '+form.border_style+'; border-top-color: '+form.border_color+'; background-color: '+form.background_color+'; display: block; position: inherit !important;'">
                <i id="spp-slup-close" class="icon-remove icon-larger" @click="isInAction = false"></i>
                <div class="block_content">
                    {{ form.content }}

                    <div class="spp-slup-ar" v-if="form.type == 'optin'">
                        <form :action="form.post_url" method="POST" class="">
                            <label class="add-on"><i class="icon-user"></i></label>
                            <input type="text" :name="form.name_field" class="span2" id="slup-name" :placeholder="form.name_label">
                            <label class="add-on"><i class="icon-envelope"></i></label>
                            <input type="email" :name="form.email_field" class="span2" id="slup-email" :placeholder="form.email_label">

                            <button type="submit" :class="'btn '+form.button_style+' '+form.button_color+' '+form.button_size">
                                {{ form.button_label }}
                            </button>
                        </form>
                    </div>

                    <div class="spp-slup-social" v-if="form.type != 'optin'">
                        <a class="icon-twitter-sign icon-larger" :href="form.twitter" v-if="form.twitter != ''"></a>
                        <a class="icon-facebook-sign icon-larger" :href="form.facebook" v-if="form.facebook != ''"></a>
                        <a class="icon-pinterest-sign icon-larger" :href="form.pinterest" v-if="form.pinterest != ''"></a>
                        <a class="icon-linkedin-sign icon-larger" :href="form.linkedin" v-if="form.linkedin != ''"></a>
                        <a class="icon-youtube-sign icon-larger" :href="form.youtube" v-if="form.youtube != ''"></a>
                        <a class="icon-rss-sign icon-larger" :href="form.rss" v-if="form.rss != ''"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear-fix"></div>
        <div class="clear-fix"></div>
        <div class="clear-fix"></div>
    </div>
</template>

<script>
    import {get, post} from '../../helpers/api';
    import {showErrorMsg, handleErrorResponse} from '../../helpers/helper';

    export default {
        data() {
            return {
                pageClass: 'page-index',
                form: {},
                isProcessing: false,
                isInAction: true,
                isInDemo: false,
                types: {
                    'adcontent': 'Ad/Content',
                    'optin': 'Opt-in',
                    'social': 'Social'
                },
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
                buttonColors: {
                    red: 'btn-danger',
                    blue: 'btn-info',
                    green: 'btn-success',
                    orange: 'btn-warning',
                    primary: 'btn-primary',
                    white: 'btn-neutral',
                    gray: 'btn-default'
                },
                buttonSizes: {
                    small: 'btn-sm',
                    medium: 'btn-md',
                    large: 'btn-lg'
                },
                buttonStyles: {
                    round: 'btn-round',
                    simple: 'btn-simple',
                    hybrid: 'btn-round btn-simple'
                }

            };
        },

        mounted() {
            this.init();

            var _this = this;

            $("#background_color, #border_color").colorpicker({
                format: 'hex',
                enableHex8: true
            });
        },

        watch: {
            isInDemo() {
                $("#is_in_demo").bootstrapSwitch({
                    onSwitchChange: (e, state) => {
                        this.isInDemo = state;
                        this.$log(this.isInDemo);
                    }
                });
                if (this.isInDemo) {
                    $("#demo_content").css('position', 'fixed');
                } else {
                    $("#demo_content").css('position', 'relative');
                }
            }
        },

        methods: {
            init() {
                Event.fire('page-loaded', this.pageClass);
                get(window.base_url+'api/slides/form').then((res) => {
                    if (res.data.success) {
                        this.form = res.data.form;
                    } else {
                        if (res.data.hasOwnProperty('message')) {
                            showErrorMsg(res.data.message);
                        }
                    }
                }, (err) => {
                    handleErrorResponse(err.response.status);
                });
            },

            saveSlide() {
                this.isProcessing = true;
                post(window.base_url+'api/slides/store', this.form).then((res) => {

                }, (err) => {
                    handleErrorResponse(err.response.status);
                }).then(() => {
                    this.isProcessing = false;
                });
            }
        }
    }
</script>