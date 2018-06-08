<template>
    <div class="card card-pricing" :data-background-color="black">
        <div class="card-body">
            <h6 class="category">{{ plan.name }}</h6>
            <div :class="`icon icon-${iconType}`">
                <i class="fa fa-fire"></i>
            </div>
            <h3 class="card-title"><small>$</small>{{ getPrice(plan.amount) }}/mo.</h3>
            <plan-features :plan="plan" :name="plan.name"></plan-features>
            
            <modal-trigger dataTarget="#paymentMethod" :class="`btn btn-${iconType} btn-round`">
                Upgrade
            </modal-trigger>
        </div>
    </div>
</template>

<script>
    import ModalTrigger from './ModalTrigger.vue';
    import PlanFeatures from './PlanFeatures.vue';

    export default {
        props: ['bgColor', 'iconType'],
        components: {
            'modal-trigger': ModalTrigger,
            'plan-features': PlanFeatures,
        },
        data() {
            return {
                plan: {}
            }
        },
        methods: {
            getPrice(amount) {
                return (amount/100).toFixed(2);
            }
        }
    }
</script>