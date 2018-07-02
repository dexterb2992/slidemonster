<template>
    <div>
        <div class="page-header page-header-small" filter-color="orange">
            <div class="page-header-image" data-parallax="true" :style="'background-image:url('+this.$router.options.base+'img/bg5.jpg)'">
            </div>
            <div class="container">
                <div class="content-center">
                    <div class="photo-container">
                        <img :src="`${baseUrl}img/default-avatar.png`" :alt="form.name">
                    </div>
                    <h3 class="title" v-text="form.name"></h3>
                    <p class="category" v-text="form.email"></p>
                    <div class="content">
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-md col-md-offset-4">
                        <div class="card">
                            <div class="card-title pl-4">
                                <h4>Upgrade</h4>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-success" role="alert" v-if="form.on_trial && !form.subscription_on_grace_period">
                                    <div class="container">
                                        <div class="alert-icon">
                                            <i class="fa fa-bell-o"></i>
                                        </div>
                                        <span><strong>On-Trial</strong> until {{ form.subscriptions[0].trial_ends_at }}</span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">
                                                <i class="fa fa-close"></i>
                                            </span>
                                        </button>
                                    </div>
                                </div>

                                <pricing></pricing>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import Flash from '../helpers/flash';
    import Auth from '../store/auth';
    import { get, post } from '../helpers/api';
    import { scrollToTop, handleErrorResponse } from '../helpers/helper';
    import Tab from '../components/Tab.vue';
    import Tabs from '../components/Tabs.vue';
    import Pricing from './Pricing.vue';

    export default {
        components: {
            'tabs': Tabs,
            'tab': Tab,
            'pricing': Pricing
        },
        data() {
            return {
                isProcessing: false,
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    license_key: ''
                },
                baseUrl: this.$router.options.base,
                error: {},
                isProcessing: false,
                initializeURL: this.$router.options.base+`api/profile`,
                pageClass: 'profile-page',
                selectedPlan: null
            }
        },
        mounted() {
            Event.fire('page-loaded', this.pageClass);

            this.init();

            Event.listen('planSelected', (plan) => {
                this.selectedPlan = plan;
            });

            Event.listen('subscriptionsUpdated', () => {
                this.init();
            });

        },
        methods: {
            init() {
                get(this.initializeURL).then((res) => {
                    Vue.set(this.$data, 'form', res.data.form);
                    Event.fire('userDataLoaded', res.data.form);
                }, (err) => {
                    handleErrorResponse(err.response.status);
                });
            }
        }
    }
</script>