<template>
    <div class="slide-feature" :data-id="feature">
        <!-- adcontent -->
        <p v-if="feature == 'adcontent'" v-html="form.content"></p>
        <!-- cta button -->
        <cta-button v-if="feature == 'cta_btn'" :form="form" :class="`btn ${form.button_style} ${form.button_color}  ${form.button_size}`"></cta-button>

        <!-- optin -->
        <div v-if="feature == 'optin'">
            <form method="POST" class="form" role="form">
                <div class="form-group">
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" :name="form.name_field" class="form-control" :placeholder="form.name_label">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group input-lg">
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" :name="form.email_field" class="form-control" :placeholder="form.email_label">
                    </div>
                </div>

                <button type="submit" :class="`btn btn-block ${form.button_style} ${form.button_color}  ${form.button_size}`">
                    {{ form.button_label }}
                </button>
            </form>
        </div>

        <!-- Countdown Timer -->
        <countdown v-if="feature == 'timer'" :form="form" :end-date="form.timer_end"></countdown>

        <!-- social -->
        <div class="social" v-if="feature == 'social'">
            <a class="icon-twitter-sign icon-larger" :href="form.twitter" v-if="!!form.twitter"></a>
            <a class="icon-facebook-sign icon-larger" :href="form.facebook" v-if="!!form.facebook"></a>
            <a class="icon-pinterest-sign icon-larger" :href="form.pinterest" v-if="!!form.pinterest"></a>
            <a class="icon-linkedin-sign icon-larger" :href="form.linkedin" v-if="!!form.linkedin"></a>
            <a class="icon-youtube-sign icon-larger" :href="form.youtube" v-if="!!form.youtube"></a>
            <a class="icon-rss-sign icon-larger" :href="form.rss" v-if="!!form.rss"></a>
        </div>
    </div>
</template>

<script>
    import CTAButton from './CTAButton.vue';
    import CountdownTimer from './CountdownTimer.vue';
    import {showInfoMsg} from '../helpers/helper';

    export default {
        props: ['form', 'feature', 'prod'],
        components: {
            'cta-button': CTAButton,
            'countdown': CountdownTimer
        },
        mounted() {
            if (this.prod !== true) {
                var count = 0;

                $(document).on('click', ".slide-feature a", function (e) {
                    e.preventDefault();
                    showInfoMsg("This event has been disabled on this page.", undefined, undefined, undefined, false);
                });

                $(document).on('click', ".slide-feature button", function (e) {
                    e.preventDefault();
                    showInfoMsg("This event has been disabled on this page.", undefined, undefined, undefined, false);
                });

                $(document).on('submit', ".slide-feature form", function (e) {
                    e.preventDefault();
                    showInfoMsg("This event has been disabled on this page.", undefined, undefined, undefined, false);
                });
            }
        }
    }
</script>