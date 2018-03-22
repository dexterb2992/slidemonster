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

<style lang="css">
    #countdown {
      width: 100%;
    }

    #countdown label {
      clear: both;
      display: block;
      font-weight: 100;
      font-size: 0.5em;
    }

    #countdown span {
        background: #313233;
        color: #FFF;
        font-size: 26px;
        font-weight: normal;
        text-align: center;
        width: 16.66%;
        display: block;
        float: left;
        border-right: 1px solid #FFF;
    },

    #countdown span.value {
        border: 1px solid white;
        padding-top: 4px;
    }

    #countdown span.sep {
        width: 6%;
        text-align: center;
        font-size: 5em;
        padding-top: 2.1%;
        padding-bottom: 2.1%;
    }

    #countdown span:last-child {
      border-right: 1px solid #313233;
    }
</style>

<!-- EVERGREEN -->
<style lang="css">
    #timermonster {
        width: 90%; 
        margin: auto;
        display: block;
    }
    #timermonster .timer-monster-box:after {
        content: '';
        clear: both;
        display: block;
    }
    #timermonster pre {
        display: block;
        font-family: monospace;
        margin: 0;
        padding: 0;
        background: initial;
        white-space: initial;
        word-break: initial;
        word-wrap: initial;
    }
    #timermonster div {
        line-height: initial;
    }
    .timer-monster-box {
        width: 100%;
        text-align: center;
        margin: 0 auto; 
    }

    .timer-monster-column {
        width: 21.25%;
    }
    .timer-monster-separator {
        width: 5%; 
    }
    .timer-monster-top {
        font-size: 25px;
    }
    .timer-monster-bottom {
        font-size: 12px;
    }

    @media  only screen and (min-width : 360px) {
    .timer-monster-top {
        font-size: 28px;
    }
    }

    @media  only screen and (min-width : 480px) {
    .timer-monster-column {
        width: 19%;
    }
    .timer-monster-separator {
        width: 8%; 
    }
    .timer-monster-top {
        font-size: 50px;
    }
    .timer-monster-bottom {
        font-size: 16px;
    }
    }

    .timer-monster-column, .timer-monster-separator {
        float: left;
        color: #000;
    }

    @media  only screen and (min-width : 768px) {
    .timer-monster-top {
        font-size: 80px;
    }
    .timer-monster-bottom {
        font-size: 20px;
    }
    }

    #timermonsterbar {
        display: block;
        width: 100%;
        background-color: white;
        margin: 0;
        color: black;
        text-align: center;
    }
    #timermonsterbar .tmb-col {
        display: inline-block;
        vertical-align: middle;
        padding: 5px;
    }
    #timermonsterbar #timermonster {
        width: 100%;
    }
    #timermonsterbar #timermonster pre {
        overflow: initial;
        margin: 0!important;
        padding: 0!important;
        border: initial!important;
        font-family: monospace!important;
        background: initial!important;
    }

    .tmb-col .timer-monster-column {
        width: auto;
    }
    .tmb-col .timer-monster-separator {
        width: auto;
    }
    a.icon-twitter-sign{color:#00ACEE}
    a.icon-facebook-sign{color:#374F8A}
    a.icon-pinterest-sign{color:#CB2027}
    a.icon-linkedin-sign{color:#1582BB}
    a.icon-youtube-sign{color:#CC181E}
    a.icon-rss-sign{color:#E4722D}
    .tmb-col>left-img,.tmb-col>right-img{max-width:96px;height:auto}
    .tm-social-icon{font-size: 30px;}

</style>

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
                console.log("new date: "+dateString);
                this.end = new Date(dateString);
                console.log("time before: "+this.time);
                this.time = this.end - new Date();
                console.log("time after: "+this.time);
            });

            if (!!this.endDate) {
                this.end = new Date(this.endDate);

                this.time = this.end - new Date();
            }
        },
    }
</script>