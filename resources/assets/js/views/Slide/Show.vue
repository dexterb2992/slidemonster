<template>
    <div>
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link :href="base_url+'css/bootstrap.min.css'" rel="stylesheet" />
        
        <link :href="base_url+'css/app.css?id=00802302014'" rel="stylesheet" />
        <link :href="base_url+'css/front.css?id=00802302014'" rel="stylesheet" />

        <see-slide-in-action :form="form" prod="true"></see-slide-in-action>
    </div>
</template>


<script>
    import axios from 'axios';
    import SeeSlideInAction from '../../components/SeeSlideInActionNew.vue';

    export default {
        components: {
            'see-slide-in-action': SeeSlideInAction
        },
        props: ['token', 'slideId'],
        data() {
            return {
                isInAction: true,
                base_url: '//slidemonster.local/',
                form: {}
            };
        },

        mounted() {
            if (window.location.host != 'slide-monster.local' && window.location.host != 'rebate-launchpad.local' && window.location.host != 'localhost') {
                this.base_url = 'https://topdogimsolutions.com/slidemonster/';
            } else {
                this.base_url = '//slidemonster.local/';
            }

            this.init();

            Event.fire('appOnProd', true);
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

                    Event.fire('formHasLoaded', this.form);

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