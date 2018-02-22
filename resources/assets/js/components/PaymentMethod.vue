<template>
    <div>
        <modal title="Payment Method" id="paymentMethod" form-wrapper="payment_form">
            <p class="text-muted">
                Your credit card information is securely stored by our payment provider. {{app_name}} does not have access to this information.
            </p>
            
            <div class="form-group">
                <label for="card-element">
                    Credit or debit card
                </label>
                <div id="card-element">
                  <!-- a Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors -->
                <div id="card-errors" role="alert" class="text-danger"></div>
            </div>

            <template slot="submit-button">
                <button type="submit" class='pay-with-stripe btn btn-success' :disabled="disabled">
                    <i class="fa fa-lock" v-if="!disabled"></i>
                    <i class="fa fa-refresh fa-spin" v-if="disabled"></i>
                 Upgrade Now</button>
            </template>
        </modal>
    </div>
</template>

<script>
    import {showSuccessMsg, showErrorMsg} from '../helpers/helper'
    import Modal from './Modal.vue';
    import ModalTrigger from './ModalTrigger.vue';;

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
                stripe: ''
            }
        },
        mounted(){
            this.createCard();
            console.log("selectedPlan: ");
            console.log(this.plan);
        },
        methods: {
            stripeTokenHandler: function (token) {
                this.$http.post('/api/payment-method/add', token)
                    .then((res) => {
                        // console.log(res.data);
                        if (res.data.success) {
                            Event.fire('card-created', res.data.card);
                            showSuccessMsg(res.data.message);
                        } else {
                            showErrorMsg(res.data.message);
                        }
                    })
                    .catch((err) => {
                        console.log(err.data);
                        showErrorMsg(err.data.message);
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