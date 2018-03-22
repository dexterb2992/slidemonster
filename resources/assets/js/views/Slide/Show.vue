<template>
    <div>
        <link :href="base_url+'css/bootstrap.min.css'" rel="stylesheet" />
        
        <link :href="base_url+'css/app.css'" rel="stylesheet" />
        <link :href="base_url+'css/front.css'" rel="stylesheet" />

        <see-slide-in-action :form="form"></see-slide-in-action>
    </div>
</template>


<script>
    import axios from 'axios';
    import SeeSlideInAction from '../../components/SeeSlideInAction.vue';

    export default {
        components: {
            'see-slide-in-action': SeeSlideInAction
        },
        props: ['token', 'slideId'],
        data() {
            return {
                isInAction: true,
                base_url: '',
                form: {}
            };
        },

        mounted() {
            if (window.location.host != 'slide-monster.local' && window.location.host != 'rebate-launchpad.local') {
                this.base_url = 'https://topdogimsolutions.com/slidemonster/';
            } else {
                this.base_url = '//slide-monster.local/';
            }

            this.init();
        },

        methods: {
            init() {
                axios({
                    method: 'GET',
                    url: `${this.base_url}api/get/slides/${this.slideId}`,
                    headers: {
                        'Authorization': `Bearer ${this.token}`
                    }
                }).then((res) => {
                    this.form = res.data;

                    if (!!this.form.timer_end) {
                        Event.fire('timerEndHasChanged', this.form.timer_end);
                    }

                }, (err) => {
                    console.warn(err);
                });
            }
        }
    }
</script>