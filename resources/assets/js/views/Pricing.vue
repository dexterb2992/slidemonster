<template>
    <div>
        <div class="alert alert-info" role="alert" v-if="onGracePeriod">
            <div class="container">
                <div class="alert-icon">
                    <i class="fa fa-bell-o"></i>
                </div>
                <strong>Heads up! </strong><span>We notice that you have cancelled your {{ previousSubscriptions[0].name }} subscription.<br/>
                You will still be able use the {{ previousSubscriptions[0].name }} features until 
                    <em class="text-danger">{{ subscriptionEnds }}</em></span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">
                        <i class="fa fa-close"></i>
                    </span>
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-4" v-if="previousSubscriptions.length < 1">
                <div class="card card-pricing card-plain">
                    <div class="card-body">
                        <h6 class="category">Free</h6>
                        <div class="icon icon-primary">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <h3 class="card-title"><small>$</small>0/mo.</h3>
                        <ul>
                            <li>Ad/Content</li>
                            <li>Countdown Timer</li>
                            <li>No Support</li>
                        </ul>
                        <a href="#pablo" class="btn btn-simple btn-primary disabled btn-round">
                            Current Plan
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-6" v-for="(plan, key) in plans">
                <div class="card card-pricing" data-background-color="black">
                    <div class="card-body">
                        <h6 class="category">{{ plan.nickname }}</h6>
                        <div :class="`icon icon-success`">
                            <i class="fa fa-fire"></i>
                        </div>
                        <h3 class="card-title"><small>$</small>{{ getPrice(plan.amount) }}/mo.</h3>
                        <plan-features :plan="plan" :name="plan.nickname"></plan-features>

                        <div v-if="userHasSubscribedTo(plan)">
                            <a class="btn btn-simple btn-primary disabled btn-round">Current Plan</a>
                            
                            <button class="btn btn-success btn-round" :disabled="resuming" v-if="onGracePeriod" title="Resume Subscription" data-toggle="tooltip" @click="resumeSubscription(plan)">
                                <i class="fa fa-spin fa-refresh" v-if="resuming"></i> Resume
                            </button>
                            <button class="btn btn-round btn-danger" @click="cancelSubscription(plan)" data-toggle="tooltip" title="Cancel Subscription" :disabled="cancelling" v-else>
                                <i class="fa fa-spin fa-refresh" v-if="cancelling"></i> Cancel
                            </button>
                        </div>
                        
                        <a class="btn btn-success btn-round" @click="selectPlan(plan)" v-else>Upgrade</a>
                    </div>
                </div>
            </div>
        </div>
        <payment-method trigger-class="btn btn-success btn-round" :selectedPlan="selectedPlan"></payment-method>
    </div>
</template>

<script>
    import {get, post} from '../helpers/api';
    import {showSuccessMsg, showErrorMsg, handleErrorResponse, getPrice} from '../helpers/helper';
    import PaymentMethod from '../components/PaymentMethod.vue';
    import SubscriptionPlan from '../components/SubscriptionPlan.vue';
    import PlanFeatures from '../components/PlanFeatures.vue';
    import ModalTrigger from '../components/ModalTrigger.vue';

    export default {
        components: {
            'payment-method': PaymentMethod,
            'plan': SubscriptionPlan,
            'plan-features': PlanFeatures,
            'modal-trigger': ModalTrigger
        },
        data() {
            return {
                base_url: window.base_url,
                plans: [],
                features: [],
                backgrounds: ['black'],
                iconTypes: ['success', 'primary', 'info', 'danger'],
                iconType: "success",
                selectedPlan: null,
                previousSubscriptions: [],
                cancelling: false,
                resuming: false,
                onGracePeriod: false,
                subscriptionEnds: null
            };
        },
        mounted() {
            this.init();

            Event.listen('userDataLoaded', (user) => {
                if (user.hasOwnProperty('subscriptions') && user.subscriptions.length > 0) {
                    this.previousSubscriptions = user.subscriptions;
                    this.onGracePeriod = user.subscription_on_grace_period;
                    this.subscriptionEnds = user.subscription_ends_at;
                }
            });
        },
        methods: {
            init() {
                get(this.base_url+'api/plans').then((res) => {
                    console.log(res.data);
                    this.plans = res.data.data;
                    console.log(this.plans);
                }, (err) => {
                    handleErrorResponse(err.response.status);
                });
            },

            // checks if user has subscribed to specific plan
            userHasSubscribedTo(plan) {
                for (var i = this.previousSubscriptions.length - 1; i >= 0; i--) {
                    if (plan.id == this.previousSubscriptions[i].stripe_plan) {
                        return true;
                    }
                }
                return false;
            },

            selectPlan(plan) {
                Event.fire('planSelected', plan);
                $("#paymentMethod").modal('show');
            },

            cancelSubscription(plan) {
                var confirmation = confirm("Are you sure to cancel this subscription?");
                if (confirmation) {
                    this.cancelling = true;
                    post(base_url+'api/cancel-subscription', {plan_id: plan.id}).then((res) => {
                        if (res.data.success) {
                            showSuccessMsg(res.data.message);
                            Event.fire('subscriptionsUpdated');
                        } else {
                            showErrorMsg(res.data.message);
                        }
                    }, (err) => {
                        handleErrorResponse(err.response.status);
                    }).then(() => {
                        this.cancelling = false;
                    });
                }
            },

            resumeSubscription(plan) {
                var confirmation = confirm("You are about to resume this subscription.");
                if (confirmation) {
                    this.resuming = true;
                    post(base_url+'api/resume-subscription', {plan_id: plan.id}).then((res) => {
                        if (res.data.success) {
                            showSuccessMsg(res.data.message);
                            Event.fire('subscriptionsUpdated');
                        } else {
                            showErrorMsg(res.data.message);
                        }
                    }, (err) => {
                        handleErrorResponse(err.response.status);
                    }).then(() => {
                        this.resuming = false;
                    });
                }
            },

            getPrice(amount) {
                return (amount/100).toFixed(2);
            }
        }
    }
</script>