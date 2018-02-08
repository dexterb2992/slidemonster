<template>
    <div>
        <link href="base_url+'css/bootstrap.min.css'" rel="stylesheet" />
        <link :href="base_url+'css/front.css'" rel="stylesheet" />
        <link :href="base_url+'css/app.css'" rel="stylesheet" />

        <div id="demo_content" v-show="isInAction" :class="'spp_slideup_container '+form.background_image" :style="'border-top-width: '+form.border_width+'px; border-top-style: '+form.border_style+'; border-top-color: '+form.border_color+'; background-color: '+form.background_color+'; display: block;'">
            <i id="spp-slup-close" class="icon-remove icon-larger" @click="isInAction = !isInAction"></i>
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
</template>


<script>
    import axios from 'axios';

    export default {
        props: ['token', 'slideId'],
        data() {
            return {
                isInAction: true,
                base_url: '//slide-monster.local/',
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
                    normal: 'btn',
                    round: 'btn-round',
                    simple: 'btn-simple',
                    hybrid: 'btn-round btn-simple'
                }
            };
        },

        mounted() {
            this.init();
        },

        methods: {
            init() {
                axios({
                    method: 'GET',
                    url: `${this.base_url}api/slides/${this.slideId}`,
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }).then((res) => {
                    this.form = res.data;
                }, (err) => {
                    console.warn(err);
                });

            }
        }
    }
</script>