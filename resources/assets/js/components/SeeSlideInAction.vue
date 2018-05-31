<template>
    <div v-show="isInAction" id="demo_content" :class="'spp_slideup_container '+form.background_image" :style="'border-top-width: '+form.border_width+'px; border-top-style: '+form.border_style+'; border-top-color: '+form.border_color+'; background-color: '+form.background_color+'; display: block;'">
        <i id="spp-slup-close" class="icon-remove icon-larger" @click="close"></i>
        <div class="block_content">
            <!-- Ad/Content & CTA Button -->
            <div v-if="inArray('adcontent', form.types)">
                <span v-html="form.content"></span>
                <cta-button :form="form" :class="`btn ${form.button_style} ${form.button_color}  ${form.button_size}`"></cta-button>
            </div>

            <!-- Opt-in -->
            <div class="spp-slup-ar" v-if="inArray('optin', form.types)">
                <form :action="form.post_url" method="POST" class="">
                    <label class="add-on"><i class="icon-user"></i></label>
                    <input type="text" :name="form.name_field" class="span2" id="slup-name" :placeholder="form.name_label">
                    <label class="add-on"><i class="icon-envelope"></i></label>
                    <input type="email" :name="form.email_field" class="span2" id="slup-email" :placeholder="form.email_label">

                    <button type="submit" :class="`btn ${form.button_style} ${form.button_color}  ${form.button_size} btn-block`">
                        {{ form.button_label }}
                    </button>
                </form>
            </div>

            <!-- Countdown Timer -->
            <countdown v-if="inArray('timer', form.types)" :form="form" :end-date="form.timer_end"></countdown>

            <!-- Social Networks -->
            <div class="spp-slup-social" v-if="inArray('social', form.types)">
                <a class="icon-twitter-sign icon-larger" :href="form.twitter" v-if="!!form.twitter"></a>
                <a class="icon-facebook-sign icon-larger" :href="form.facebook" v-if="!!form.facebook"></a>
                <a class="icon-pinterest-sign icon-larger" :href="form.pinterest" v-if="!!form.pinterest"></a>
                <a class="icon-linkedin-sign icon-larger" :href="form.linkedin" v-if="!!form.linkedin"></a>
                <a class="icon-youtube-sign icon-larger" :href="form.youtube" v-if="!!form.youtube"></a>
                <a class="icon-rss-sign icon-larger" :href="form.rss" v-if="!!form.rss"></a>
            </div>


        </div>
    </div>
</template>

<script>
    import CTAButton from './CTAButton.vue';
    import CountdownTimer from './CountdownTimer.vue';

    export default {
        props: ['form'],
        components: {
            'cta-button': CTAButton,
            'countdown': CountdownTimer
        },
        data() {
            return {
                isInAction: true
            };
        },
        methods: {
            close() {
                try {
                    this.isInAction = false;
                    Event.fire('closeSlide');
                } catch (e) {
                    console.warn(e);
                }
            },

            inArray: (needle, haystack) => {
                try {
                    var length = haystack.length;
                    for(var i = 0; i < length; i++) {
                        if(haystack[i] == needle) return true;
                    }
                } catch (e) {
                    // console.warn(e);
                }
                return false;
            }
        }
    }
</script>