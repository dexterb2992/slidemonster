<template>
    <div>
        <link :href="base_url+'css/bootstrap.min.css'" rel="stylesheet" />
        <link :href="base_url+'css/front.css'" rel="stylesheet" />
        <link :href="base_url+'css/app.css'" rel="stylesheet" />

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
            if (window.location.host != 'slide-monster.local') {
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