<template>
    <div class="slide-form-wrapper">
        <div class="container">
            <form class="">
                <div class="section">
                    <div class="row">
                        <div class="form-group col">
                            <label class="col">Title</label>
                            <input type="text" v-model="form.title" class="form-control col" placeholder="Title">
                        </div>
                        <div class="form-group col">
                            <label class="col">Type</label>
                            <select v-model="form.type" class="form-control col">
                                <option v-for="(type, key) in types" :key="key" :value="key">{{ type }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label>Content</label>
                            <textarea v-model="form.content" class="form-control" placeholder="Add your content..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <legend>Design</legend>
                    <h5>Border</h5>
                    <div class="row">
                        <div class="form-group col">
                            <label class="col">Width: </label>
                            <div class="input-group col">
                                <input type="text" v-model="form.border_width" class="form-control" placeholder="Border width">
                                <div class="input-group-addon">
                                    <div class="input-group-text">px</div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col">
                            <label class="col">Style</label>
                            <select class="form-control col" v-model="form.border_style">
                                <option disabled>Border Style</option>
                                <option v-for="(borderStyle, key) in borderStyles" :key="key" :value="key">
                                    {{ borderStyle }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label class="col">Color: </label>
                            <div id="border_color" class="input-group colorpicker-component">
                                <input type="text" class="form-control" placeholder="Border color" />
                                <span class="input-group-addon"><i></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>
                            Choose a background color, Or choose a background image...
                        </label>
                        <div class="row">
                            <div class="col-md-3">
                                <div id="background_color" class="input-group colorpicker-component">
                                    <input type="text" class="form-control" placeholder="Background color" />
                                    <span class="input-group-addon"><i></i></span>
                                </div>

                            </div>
                            <div class="col">
                                <span v-for="(backgroundImage, key) in backgroundImages" :key="key" class="radio col">
                                    <input type="radio" class="form-control" :id="'rad_'+key" :value="key" v-model="form.background_image">
                                    <label :for="'rad_'+key">{{ backgroundImage }}</label>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section" v-if="form.type == 'optin'">
                    <legend>Optin</legend>

                    <div class="form-group row">
                        <label class="col">Paste Your Autoresponder Code</label>
                        <textarea class="form-control" v-model="form.autoresponder_code"></textarea>
                    </div>

                    <div class="form-group row">
                        <label class="col">Name Field</label>
                        <input type="text" class="form-control" v-model="form.name">
                    </div>
                    <div class="form-group row">
                        <label class="col">Email Field</label>
                        <input type="text" class="form-control" v-model="form.email">
                    </div>
                    <div class="form-group row">
                        <label class="col">AR Post URL</label>
                        <input type="text" class="form-control" v-model="form.post_url">
                    </div>
                    <div class="form-group row">
                        <label class="col">Hidden Fields</label>
                        <textarea class="form-control" v-model="form.hidden_fields"></textarea>
                    </div>
                    <div class="form-group row">
                        <label class="col">Name Field Label</label>
                        <div class="col">
                            <input type="text" class="form-control" v-model="form.name_label">
                            <small class="help-text">Text that appears in the name field</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col">Email Field Label</label>
                        <div class="col">
                            <input type="text" class="form-control" v-model="form.email_label">
                            <small class="help-text">Text that appears in the email field</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col">Button Label</label>
                        <div class="col">
                            <input type="text" class="form-control" v-model="form.button_label">
                            <small class="help-text">Text that appears in the button</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col">Submit Button Color</label>
                        <div v-for="(buttonColor, key) in buttonColors" :key="key" class="col-md-8">
                            <a :class="'btn '+buttonColor">{{ key }}</a>
                            <input type="radio" class="form-control" v-model="form.button_color" :value="key">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col">Button Style</label>
                        <div v-for="(buttonStyle, key) in buttonStyles" :key="key" class="col">
                            <a :class="'btn '+buttonStyle" @click="form.button_color = key">{{ key }}</a>
                            <input type="radio" class="form-control" v-model="form.button_color" :value="key">
                        </div>
                    </div>
                </div>

                <div class="section" v-if="form.type == 'social'">
                    <legend>Social</legend>
                    <small class="help">Enter your social profile URL. Leave empty to disable.</small>

                    <div class="form-group">
                        <label class="col-md-4">Twitter</label>
                        <input type="url" class="form-control" v-model="form.twitter">
                    </div>

                    <div class="form-group">
                        <label class="col-md-4">Facebook</label>
                        <input type="url" class="form-control" v-model="form.facebook">
                    </div>

                    <div class="form-group">
                        <label class="col-md-4">Pinterest</label>
                        <input type="url" class="form-control" v-model="form.pinterest">
                    </div>

                    <div class="form-group">
                        <label class="col-md-4">LinkedIn</label>
                        <input type="url" class="form-control" v-model="form.linkedin">
                    </div>

                    <div class="form-group">
                        <label class="col-md-4">Youtube</label>
                        <input type="url" class="form-control" v-model="form.youtube">
                    </div>

                    <div class="form-group">
                        <label class="col-md-4">RSS</label>
                        <input type="url" class="form-control" v-model="form.rss">
                    </div>
                </div>
            </form>
        </div>
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
                    "gold-scale": "Gold Scale",
                    "light-wool": "Light Wool",
                    "paper2": "Paper 2",
                    "paper3": "Paper 3",
                    "ps-neutral": "PS Neutral",
                    "tweed": "Tweed"
                },
                buttonColors: {
                    red: 'btn-danger',
                    blue: 'btn-info',
                    green: 'btn-success',
                    orange: 'btn-warning',
                    primary: 'btn-primary',
                    white: 'btn-default',
                    pink: 'btn-default bg-pink',
                    black: 'btn-default bg-black',
                    grey: 'btn-default bg-grey'
                },
                buttonStyles: {
                    small: 'btn-sm',
                    medium: 'btn-md',
                    large: 'btn-lg',
                    rounded: 'btn-rounded'
                }

            };
        },

        mounted() {
            this.init();

            var _this = this;
            $('#background_color').colorpicker({
                color: _this.form.background_color
            }).on('changeColor', function (e) {
                _this.form.background_color = e.color.toHex();
            });

            $('#border_color').colorpicker({
                color: _this.form.border_color
            }).on('changeColor', function (e) {
                _this.form.border_color = e.color.toHex();
            });
        },

        methods: {
            init() {
                Event.fire('page-loaded', this.pageClass);
                get(this.$router.options.base+'api/slides/form').then((res) => {
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
            }
        }
    }
</script>