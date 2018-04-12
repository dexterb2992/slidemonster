<template>
    <countdown :time="time" tag="div">
        <template slot-scope="props">

            <div id="countdown" v-if="form.timer_type != 'evergreen'">
                <span class="value days">{{ props.days }} <label>Days</label></span>
                <!-- <span class="sep"><label>:</label></span> -->
                <span class="value hours">{{ props.hours }} <label>Hours</label></span>
                <!-- <span class="sep"><label>:</label></span> -->
                <span class="value minutes">{{ props.minutes }} <label>Minutes</label></span>
                <!-- <span class="sep"><label>:</label></span> -->
                <span class="value seconds">{{ props.seconds }} <label>Seconds</label></span>
            </div>

            <div id="timermonster" v-else>
                <div class="timer-monster-box">
                    <div class="timer-monster-column tm-day">
                        <div class="timer-monster-top">{{ props.days }}</div>
                        <div class="timer-monster-bottom" data-label="days,day">days</div>
                    </div>
                    <div class="timer-monster-separator">
                        <div class="timer-monster-top">:</div>
                        <div class="timer-monster-bottom">&nbsp;</div>
                    </div>
                    <div class="timer-monster-column tm-hour">
                        <div class="timer-monster-top">{{ props.hours }}</div>
                        <div class="timer-monster-bottom" data-label="hours,hour">hours</div>
                    </div>
                    <div class="timer-monster-separator">
                        <div class="timer-monster-top">:</div>
                        <div class="timer-monster-bottom">&nbsp;</div>
                    </div>
                    <div class="timer-monster-column tm-minute">
                        <div class="timer-monster-top">{{ props.minutes }}</div>
                        <div class="timer-monster-bottom" data-label="minutes,minute">minutes</div>
                    </div>
                    <div class="timer-monster-separator">
                        <div class="timer-monster-top">:</div>
                        <div class="timer-monster-bottom">&nbsp;</div>
                    </div>
                    <div class="timer-monster-column tm-second">
                        <div class="timer-monster-top">{{ props.seconds }}</div>
                        <div class="timer-monster-bottom" data-label="seconds,second">seconds</div>
                    </div>
                </div>
            </div>
        </template>
    </countdown>
</template>

<script>
    import VueCountdown from '@xkeshi/vue-countdown'

    export default {
        props: ['endDate', 'form'],
        components: {
            'countdown': VueCountdown
        },
        data() {
            let now = new Date();

            return {
                end: new Date(),
                time: 2 * 24 * 60 * 60 * 1000
            };            
        },
        computed: {
            labelShadowBlur() {
                return this.form.timer_label_text_shadow_blur == null ? '0px' : this.form.timer_label_text_shadow_blur+'px';
            },
            digitShadowBlur() {
                return this.form.timer_digit_text_shadow_blur == null ? '0px' : this.form.timer_digit_text_shadow_blur+'px';
            },
            digitFontSize() {
                this.init();
                return this.form.timer_digit_size+'px';
            },
            digitColor() {
                return this.form.timer_digit_color;
            },
            digitTextShadow() {
                return `${this.form.timer_digit_text_shadow_color} ${this.form.timer_digit_text_shadow_x}px ${this.form.timer_digit_text_shadow_y}px ${this.digitShadowBlur}`;
            },

            labelFontSize() {
                return this.form.timer_label_size+'px';
            },
            labelColor() {
                return this.form.timer_label_color;
            },
            labelTextShadow() {
                return `${this.form.timer_label_text_shadow_color} ${this.form.timer_label_text_shadow_x}px ${this.form.timer_label_text_shadow_y}px ${this.digitShadowBlur}`;
            }
        },
        watch: {
            digitFontSize: function (newVal, oldVal) {
                $(".timer-monster-top").css('fontSize', newVal);
            },
            digitColor: function (newVal, oldVal) {
                this.toggleDigitColor(newVal);
            },
            digitTextShadow: function (newVal, oldVal) {
                this.toggleDigitTextShadow(newVal);
            },
            labelFontSize: function (newVal, oldVal) {
                $(".timer-monster-bottom").css('fontSize', newVal);
            },
            labelColor: function (newVal, oldVal) {
                this.toggleLabelColor(newVal);
            },
            labelTextShadow: function (newVal, oldVal) {
                this.toggleLabelTextShadow(newVal);
            }
        },
        methods: {
            init() {
                this.toggleDigitColor(this.form.timer_digit_color); console.log('timer_digit_color...');
                this.toggleDigitTextShadow(this.form.timer_digit_text_shadow_color);console.log('timer_digit_text_shadow_color...');
                this.toggleLabelColor(this.form.timer_label_color);console.log('timer_label_color...');
                this.toggleLabelTextShadow(this.form.timer_label_text_shadow_color);console.log('timer_label_text_shadow_color...');
            },
            toggleDigitColor(newVal) {
                $(".timer-monster-top").css('color', newVal);
            },
            toggleDigitTextShadow(newVal) {
                let shadow = `${this.form.timer_digit_text_shadow_color} ${this.form.timer_digit_text_shadow_x}px ${this.form.timer_digit_text_shadow_y}px ${this.digitShadowBlur}`;
                $(".timer-monster-top").css('textShadow', shadow);
            },
            toggleLabelColor(newVal) {
                $(".timer-monster-bottom").css('color', newVal);
            },
            toggleLabelTextShadow(newVal) {
                let shadow = `${this.form.timer_label_text_shadow_color} ${this.form.timer_label_text_shadow_x}px ${this.form.timer_label_text_shadow_y}px ${this.digitShadowBlur}`;
                $(".timer-monster-bottom").css('textShadow', shadow);
            }
        },
        mounted() {
            this.init();

            Event.listen('timerEndHasChanged', (dateString) => {
                this.end = new Date(dateString);
                this.time = this.end - new Date();
            });

            if (!!this.endDate) {
                this.end = new Date(this.endDate);
                this.time = this.end - new Date();
            }

            Event.listen('colorPickerChanged', (data) => {
                // this.form[data.id] = data.value;
                switch(data.id) {
                    case 'timer_digit_color':
                        this.toggleDigitColor(data.value);
                        break;
                    case 'timer_digit_text_shadow_color':
                        this.toggleDigitTextShadow(data.value);
                        break;
                    case 'timer_label_color':
                        this.toggleLabelColor(data.value);
                        break;
                    case 'timer_label_text_shadow_color':
                        this.toggleLabelTextShadow(data.value);
                        break;
                }
            });
        }
    }
</script>