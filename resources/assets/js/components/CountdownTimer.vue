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
            }
        },

        mounted() {
            Event.listen('timerEndHasChanged', (dateString) => {
                this.end = new Date(dateString);
                this.time = this.end - new Date();
            });

            if (!!this.endDate) {
                this.end = new Date(this.endDate);

                this.time = this.end - new Date();
            }
        },
    }
</script>