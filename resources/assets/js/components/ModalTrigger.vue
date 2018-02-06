<template>
    <button :class="triggerClass" data-toggle="modal" :data-target="dataTarget">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: ['dataTarget'],
        data() {
            return {
                triggerClass: typeof(this.class) != 'undefined' ? this.class : 'btn btn-primary'
            }
        }
    }
</script>