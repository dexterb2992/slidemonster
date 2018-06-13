<template>
    <div>
        <modal title="Payment Method" id="paymentMethod" form-wrapper="payment_form">
            <p class="text-muted">
                Your credit card information is securely stored by our payment provider. {{app_name}} does not have access to this information.
            </p>
            
            <div class="form-group">
                <label for="card-element">
                    Enter your Credit or Debit card
                </label>
                <div id="card-element">
                  <!-- a Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors -->
                <div id="card-errors" role="alert" class="text-danger"></div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <label for="coupon">Do you have a coupon code?</label>
                </div>
                <div class="col-md-6 form-group">
                    <input class="form-control" id="coupon" v-model="couponText" placeholder="Enter Coupon" @change="verifyCoupon" />
                    <div>
                        <span class="error-control text-info" v-if="checkingCoupon"><i class="fa fa-refresh fa-spin"></i> checking...</span>
                        <em class="text-danger error-control pull-right" v-if="couponErrors != ''">{{ couponErrors }}</em>
                        <strong class="text-primary pull-right" v-if="hasCoupon">
                            <span v-if="couponAmountOff">$ {{ couponAmountOff }} off</span>
                            <span v-if="couponPercentOff">{{ couponPercentOff }}% off</span>
                        </strong>
                    </div>
                </div>
            </div>

            <template slot="submit-button">
                <button type="submit" class='pay-with-stripe btn btn-success' :disabled="disabled">
                    <i class="fa fa-lock" v-if="!disabled"></i>
                    <i class="fa fa-refresh fa-spin" v-if="disabled"></i>
                 <!-- Upgrade Now for ($<strong>{{ (selectedPlan.amount/100).toFixed(2) }}</strong>)</button> -->
                 Upgrade Now for ($<strong>{{ selectedPlan.amount }}</strong>)</button>
            </template>
        </modal>
    </div>
</template>

<script>
    import {showSuccessMsg, showErrorMsg, getPrice, handleErrorResponse} from '../helpers/helper';
    import {get, post} from '../helpers/api';
    import Modal from './Modal.vue';
    import ModalTrigger from './ModalTrigger.vue';
    import Auth from '../store/auth';

    export default {
        props: ['triggerClass', 'plan'],
        components: {
            'modal-trigger': ModalTrigger,
            'modal': Modal
        },
        data(){
            return {
                app_name: window.app_name,
                stripeKey: window.stripe_key,
                base_url: window.base_url,
                disabled: false,
                cardError: null,
                stripeOptions: {
                    base: {
                        color: '#32325d',
                        lineHeight: '18px',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                          color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                },
                stripe: '',
                selectedPlan: {
                    amount: 0
                },
                couponText: '',
                coupon: null,
                hasCoupon: false,
                couponErrors: null,
                couponPercentOff: false,
                couponAmountOff: false,
                checkingCoupon: false
            }
        },
        mounted(){
            this.createCard();
            Event.listen('planSelected', (plan) => {
                this.selectedPlan = plan;
                this.selectedPlan.amount = plan.price_per_unit;
                // this.selectedPlan.formatted_amount = getPrice(plan.amount);
                this.selectedPlan.formatted_amount = this.selectedPlan.amount;
            });
        },
        methods: {
            verifyCoupon() {
                console.log('listening to change event...');

                if (this.couponText == "") {
                    this.toggleCouponStatus(null);
                } else {
                    var self = this;

                    $.ajax({
                        headers: {
                            'Authorization': `Bearer `+Auth.state.api_token
                        },
                        type: 'get',
                        url: base_url+'api/coupons',
                        data: {
                            coupon: this.couponText
                        },
                        beforeSend: () => {
                            this.checkingCoupon = true;
                        },
                        complete: () => {
                            this.checkingCoupon = false;
                        },
                        success: (data) => {
                            if (data.success) {
                                if (data.coupon.valid) {
                                    this.coupon = data.coupon;
                                    this.hasCoupon = true;

                                    // recalculate selectedPlan amount
                                    if (this.coupon.amount_off) {
                                        this.selectedPlan.amount -= this.coupon.amount_off;
                                    }

                                    if (this.coupon.percent_off) {
                                        this.selectedPlan.amount -= ((this.selectedPlan.amount) * (this.coupon.percent_off/100));
                                    }

                                    this.toggleCouponStatus(true);
                                } else {
                                    this.couponErrors = "This coupon is no longer valid.";
                                    this.toggleCouponStatus(false);
                                }
                            } else {
                                this.coupon = null;
                                this.couponErrors = data.message;
                                this.toggleCouponStatus(false);
                            }
                        },
                        error: (err) => {
                            console.warn(err);
                            this.toggleCouponStatus(null);
                        }
                    })
                }
            },

            toggleCouponStatus(status) {
                if (status == null) {
                    this.hasCoupon = false;
                    this.coupon = null;
                    this.couponErrors = null;
                    this.couponPercentOff = false;
                    this.couponAmountOff = false;
                    $("#coupon").parents(".form-group").removeClass("has-danger").removeClass("has-success");
                    this.selectedPlan.amount = this.selectedPlan.formatted_amount * 100; // revert to cents
                } else {
                    if (status) {
                        this.couponErrors = '';
                        this.couponPercentOff = this.coupon.percent_off;
                        this.couponAmountOff = this.coupon.amount_off;
                        $("#coupon").parents(".form-group").removeClass("has-danger").addClass("has-success");
                    } else {
                        $("#coupon").parents(".form-group").removeClass("has-success").addClass("has-danger");
                        this.couponPercentOff = false;
                        this.couponAmountOff = false;
                        this.selectedPlan.amount = this.selectedPlan.formatted_amount * 100; // revert to cents
                    }
                }
            },

            stripeTokenHandler (token) {
                var data = {
                    token: token,
                    plan_id: this.selectedPlan.id,
                    coupon: this.hasCoupon ? this.couponText : ''
                }
                this.disabled = true;
                post(base_url+'api/subscribe', data).then((res) => {
                    console.log(res.data);
                    if (res.data.hasOwnProperty('message')) {
                        if (res.data.success) {
                            showSuccessMsg(res.data.message);
                            $("#payment_form").modal('hide');
                            // setTimeout(function() {
                            //     window.location.reload();
                            // }, 5000);
                            Event.fire('subscriptionsUpdated');
                        } else {
                            showErrorMsg(res.data.message);
                        }
                    }
                }, (err) => {
                    console.warn(err.data);
                    handleErrorResponse(err.response.status);
                }).then(() => {
                    this.disabled = false;
                });
            },

            createCard(){
                var $this = this;

                // Create a Stripe client
                var stripe = Stripe(this.stripeKey);

                // Create an instance of Elements
                var elements = stripe.elements();

                // Custom styling can be passed to options when creating an Element.
                // (Note that this demo uses a wider set of styles than the guide below.)
                var style = {
                    base: {
                        color: '#32325d',
                        lineHeight: '18px',
                        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                        fontSmoothing: 'antialiased',
                        fontSize: '16px',
                        '::placeholder': {
                            color: '#aab7c4'
                        }
                    },
                    invalid: {
                        color: '#fa755a',
                        iconColor: '#fa755a'
                    }
                };

                // Create an instance of the card Element
                var card = elements.create('card', {style: style});

                // Add an instance of the card Element into the `card-element` <div>
                card.mount('#card-element');

                // Handle real-time validation errors from the card Element.
                card.addEventListener('change', function(event) {
                    var displayError = document.getElementById('card-errors');
                    $this.cardError = event.error;
                    if (event.error) {
                        displayError.textContent = event.error.message;
                    } else {
                        displayError.textContent = '';
                    }
                });

                // Handle form submission
                var form = document.getElementById('payment_form');
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    if (!$this.cardError) {
                        $this.disabled = true;
                    }

                    stripe.createToken(card).then(function(result) {
                        $this.disabled = false;

                        if (result.error) {
                            // Inform the user if there was an error
                            var errorElement = document.getElementById('card-errors');
                            errorElement.textContent = result.error.message;
                        } else {
                            // Send the token to your server
                            $this.stripeTokenHandler(result.token);
                        }
                    });
                });
            }
        }
    }
</script>