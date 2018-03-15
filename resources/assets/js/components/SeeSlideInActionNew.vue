<template>
    <div v-show="isInAction" id="demo_content" :class="'row '+form.background_image" :style="'border-top-width: '+form.border_width+'px; border-top-style: '+form.border_style+'; border-top-color: '+form.border_color+'; background-color: '+form.background_color+'; display: block;'">
        <i id="spp-slup-close" class="icon-remove icon-larger" @click="close"></i>
        
        <div class="col">
            
        </div>
        <div class="col">
            <!-- adcontent -->
            <span v-if="inArray('adcontent', form.types)" v-html="form.content"></span>

            <!-- optin -->
            <div class="spp-slup-ar" v-if="inArray('optin', form.types)">
                <form method="POST" class="form" role="form">
                    <div class="form-group">
                        <div class="input-group input-lg">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" name="name" placeholder="Name" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group input-lg">
                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email" placeholder="Email" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-simple btn-success  btn-lg">
                        Subscribe
                    </button>
                </form>
            </div>

            <!-- social -->
            <div class="spp-slup-social" v-if="inArray('social', form.types)">
                <a class="icon-twitter-sign icon-larger" :href="form.twitter" v-if="!!form.twitter"></a>
                <a class="icon-facebook-sign icon-larger" :href="form.facebook" v-if="!!form.facebook"></a>
                <a class="icon-pinterest-sign icon-larger" :href="form.pinterest" v-if="!!form.pinterest"></a>
                <a class="icon-linkedin-sign icon-larger" :href="form.linkedin" v-if="!!form.linkedin"></a>
                <a class="icon-youtube-sign icon-larger" :href="form.youtube" v-if="!!form.youtube"></a>
                <a class="icon-rss-sign icon-larger" :href="form.rss" v-if="!!form.rss"></a>
            </div>
        </div>
        <div class="col">
            <!-- cta button -->
            <cta-button :form="form" :class="`btn ${form.button_style} ${form.button_color}  ${form.button_size}`"></cta-button>
        </div>

    </div>
</template>

<script>
    import CTAButton from './CTAButton.vue';

    export default {
        props: ['form'],
        components: {
            'cta-button': CTAButton
        },
        data() {
            return {
                isInAction: true
            }
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
                var length = haystack.length;
                for(var i = 0; i < length; i++) {
                    if(haystack[i] == needle) return true;
                }
                return false;
            }
        }
    }
</script>