<template>
    <div class="row">
        <div class="col">
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
                    <a href="#pablo" class="btn btn-neutral btn-primary disabled btn-round">
                        Current Plan
                    </a>
                </div>
            </div>
        </div>
        
        <!-- <div v-for="plan in plans" class="col">
            <plan :plan="plan" :icon-type="getRandomItem(iconTypes)"></plan>
        </div> -->
        <div class="col" v-for="(plan, key) in plans">
            <div class="card card-pricing" data-background-color="black">
                <div class="card-body">
                    <h6 class="category">{{ plan.name }}</h6>
                    <div :class="`icon icon-success`">
                        <i class="fa fa-fire"></i>
                    </div>
                    <h3 class="card-title"><small>$</small>{{ getPrice(plan.amount) }}/mo.</h3>
                    <plan-features :plan="plan" :name="plan.name"></plan-features>
                    <!-- <ul> -->
                        
                        <!-- <li>Ad/Content</li>
                        <li>Countdown Timer</li>
                        <li>Social</li>
                        <li>Opt-In</li>
                        <li>Full Support</li> -->
                    <!-- </ul> -->
                   <!--  <a href="#upgrade" class="btn btn-success btn-round">
                        Upgrade
                    </a> -->
                    
                    <modal-trigger dataTarget="#paymentMethod" :class="`btn btn-success btn-round`" @click="selectedPlan = plan">
                        Upgrade
                    </modal-trigger>
                </div>
            </div>
        </div>

        <payment-method trigger-class="btn btn-success btn-round"></payment-method>
    </div>
</template>

<script>
    import {get, post} from '../helpers/api';
    import {showErrorMsg, handleErrorResponse} from '../helpers/helper';
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
                selectedPlan: null
            };
        },
        mounted() {
            this.init();
        },
        methods: {
            init() {
                get(this.base_url+'api/plans').then((res) => {
                    console.log(res.data);
                    this.plans = res.data.data;
                }, (err) => {
                    handleErrorResponse(err.response.status);
                });
            },

            randomize(max) {
                return Math.floor(Math.random() * (max - 0 + 1)) + 0;
            },

            getRandomItem(items) {
                return items[this.randomize(items.length)];
            },

            getPrice(amount) {
                return (amount/100).toFixed(2);
            }
        }
    }
</script>