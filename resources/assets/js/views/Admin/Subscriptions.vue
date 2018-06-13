<template>
    <div class="slide-form-wrapper container">
        <div class="form-inner-wrapper">
            <div class="section">
                <h5 class="title">
                    Subscription Plans &amp; Features
                </h5>
                
            </div>

            <div class="section">
                <div class="row">
                    <div class="col-md-4">
                        <form @submit.prevent="addPlan">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" v-model="newPlan.name">
                            </div>
                            <div class="form-group">
                                <label>Stripe Plan ID</label>
                                <input type="text" class="form-control" v-model="newPlan.stripe_plan">
                            </div>
                            <!-- <div class="form-group">
                                <label>interval</label>
                                <input type="number" class="form-control" v-model="newPlan.interval">
                            </div> -->
                            <div class="form-group">
                                <label>Unit</label>
                                <select class="form-control" v-model="newPlan.unit">
                                    <option v-for="(item, key) in planUnits" :value="item.unit" v-text="item.unit_text"></option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Price (per unit)</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-dollar"></i>
                                    </span>
                                    <input type="number" v-model="newPlan.price_per_unit" class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn-info btn" :disabled="savingPlan" type="submit">
                                    <i class="fa fa-check" v-if="!savingPlan"></i>
                                    <i class="fa fa-refresh fa-spin" v-if="savingPlan"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-8">
                        <table class="table table-responsive">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Stripe Plan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(plan, key) in plans">
                                    <td>
                                        {{ plan.name+' ($'+plan.price_per_unit+')' }} <span class="label label-info">{{ plan.unit_text }}</span>
                                    </td>
                                    <td v-text="plan.stripe_plan"></td>
                                    <td>
                                        <a href="javascript:void(0)" class="btn btn-warning btn-simple" @click="newPlan = plan; newPlan.mode = 'edit';" :disabled="savingPlan">
                                            <i class="fa-edit fa" v-if="!savingPlan"></i>
                                            <i class="fa-refresh fa fa-spin" v-if="savingPlan"></i> Edit
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-danger btn-simple" @click="deletePlan(key)" :disabled="deletingPlan">
                                            <i class="fa fa-close" v-if="!deletingPlan"></i>
                                            <i class="fa fa-refresh fa-spin" v-if="deletingPlan"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="section">
                <form @submit.prevent="addFeature">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select class="custom-select" v-model="newFeature.plan_id">
                                <option value="" selected>Select Plan...</option>
                                <option v-for="(plan, key) in plans" :value="plan.id">
                                    <!-- {{ plan.nickname }} -->
                                    {{ plan.name }}
                                </option>
                            </select>
                        </div>

                        <input type="text" class="form-control" style="padding: 10px 18px 10px 18px;height: calc(2.25rem + 2px);" placeholder="New Feature" aria-label="New Feature" aria-describedby="basic-addon2" v-model="newFeature.content">
                        
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-secondary" style="margin-top: 0;" :disabled="disabled">
                                <i class="fa fa-spin fa-refresh" v-if="disabled"></i> Add
                            </button>
                        </div>
                    </div>
                </form>
                <div class="form-inline form-group pull-right">
                    <input type="text" class="form-control" placeholder="Search..." v-model="search">
                </div>

                <table class="table table-bordered table-responsive">
                    <caption>List of Subscriptions</caption>
                    <thead class="thead-dark">
                        <tr>
                            <th>Plan</th>
                            <th>Price</th>
                            <th>Features</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(plan, key) in filteredPlans">
                            <!-- <td><strong>{{ plan.nickname }}</strong></td> -->
                            <td><strong>{{ plan.name }}</strong></td>
                            <td>
                                <strong class="text-primary pull-right">
                                    <!-- ${{ getPrice(plan.amount) }} -->
                                    ${{ plan.price_per_unit }}
                                </strong>
                            </td>
                            <td>
                                <!-- <plan-features :plan="plan" :name="plan.nickname" edit-mode="true"></plan-features> -->
                                <plan-features :plan="plan" :name="plan.name" edit-mode="true"></plan-features>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>

<script>
    // import SubscriptionPlan from '../../components/SubscriptionPlan.vue';
    import PlanFeatures from '../../components/PlanFeatures.vue';
    import {get, post, del} from '../../helpers/api';
    import {showSuccessMsg, showErrorMsg, handleErrorResponse} from '../../helpers/helper';

    export default {
        components: {
            // 'plan': SubscriptionPlan,
            'plan-features': PlanFeatures
        },
        data() {
            return {
                base_url: window.base_url,
                plans: [],
                search: '',
                disabled: false,
                savingPlan: false,
                deletingPlan: false,
                newFeature: {
                    content: '',
                    plan_id: ''
                },

                planUnits: {
                    'daily': {
                        'interval': 1,
                        'unit': 'days',
                        'unit_text': 'Daily'
                    },
                    'weekly': {
                        'interval': 1,
                        'unit': 'weeks',
                        'unit_text': 'Weekly'
                    },
                    'monthly': {
                        'interval': 1,
                        'unit': 'months',
                        'unit_text': 'Monthly'
                    },
                    '3mo': {
                        'interval': 3,
                        'unit': 'months',
                        'unit_text': 'Every 3 months'
                    },
                    '6mo': {
                        'interval': 6,
                        'unit': 'months',
                        'unit_text': 'Every 6 months'
                    },
                    'yearly': {
                        'interval': 1,
                        'unit': 'years',
                        'unit_text': 'Yearly'
                    }
                },

                newPlan: {
                    name: '',
                    stripe_plan: '',
                    interval: 1,
                    unit: 'months',
                    unit_text: 'Monthly',
                    trial_days: 0,
                    price_per_unit: 0,
                    mode: 'create'
                }
            }
        },
        mounted() {
            Event.fire('page-loaded', 'page-index');
            this.getAllPlans();
        },
        computed: {
            filteredPlans() {
                return this.plans.filter(plan => {
                    // return plan.nickname.toLowerCase().includes(this.search.toLowerCase()) ||
                    return plan.name.toLowerCase().includes(this.search.toLowerCase()) ||
                        plan.id.toLowerCase().includes(this.search.toLowerCase());
                })
            }
        },
        methods: {
            getAllPlans() {
                get(this.base_url+'api/plans').then((res) => {
                    console.log(res.data);
                    // this.plans = res.data.data;
                    this.plans = res.data;

                    $.each(this.plans, (i, plan) => {
                        this.getFeatures(plan);
                    });

                }, (err) => {
                    handleErrorResponse(err.response.status);
                });
            },

            getFeatures(plan) {
                get(this.base_url+'api/plans/'+plan.id+'/features').then((res) => {
                    plan.features = res.data;
                }, (err) => {
                    if (err.data.message) {
                        showErrorMsg(err.data.message);
                    }
                });
            },

            addFeature() {
                if (this.newFeature.plan_id != '') {
                    post(this.base_url+'api/features', this.newFeature).then((res) => {
                        if (res.data.success) {
                            var feature = this.newFeature;
                            feature.id = res.data.id;
                            Event.fire('featureCreated', this.newFeature);
                            showSuccessMsg(res.data.message);
                            this.newFeature = {
                                content: '',
                                plan_id: ''
                            }
                        } else {
                            if (res.data.hasOwnProperty('message')) {
                                showErrorMsg(res.data.message);
                            }
                        }
                    }, (err) => {
                        handleErrorResponse(err.response.status);
                    });
                }
            },

            getPrice(amount) {
                return (amount/100).toFixed(2);
            },

            addPlan() {
                let __request = null;

                if (this.newPlan.mode == 'create') {
                    __request = post(this.base_url+'api/subscription-plans/store', this.newPlan);
                } else {
                    __request = post(this.base_url+'api/subscription-plans/update/'+this.newPlan.id, this.newPlan)
                }

                __request.then((res) => {
                    if (res.data.success) {
                        showSuccessMsg(res.data.message);
                        

                        if (this.newPlan.mode == 'create') {
                            this.newPlan.id = res.data.id;
                            this.plans.push(this.newPlan);
                        }
                        

                        this.newPlan = {
                            name: '',
                            stripe_plan: '',
                            interval: 1,
                            unit: 'months',
                            unit_text: 'Monthly',
                            trial_days: 0,
                            price_per_unit: 0,
                            mode: 'create'
                        };

                    } else {
                        showErrorMsg(res.data.message);
                    }
                }, (err) => {
                    handleErrorResponse(err.response.status);
                });
            },

            deletePlan(key) {
                let plan = this.plans[key];

                if (!confirm("Are you sure to delete this subscription plan? You can not undo this action.")) {
                    return;
                }

                del(this.base_url+'api/subscription-plans/delete/'+plan.id).then((res) => {
                    if (res.data.success) {
                        this.plans.splice(key, 1);
                        showSuccessMsg(res.data.message);
                    } else {
                        showErrorMsg(res.data.message);
                    }
                }, (err) => {
                    handleErrorResponse(err.response.status);
                });
            }
        }
    }
</script>