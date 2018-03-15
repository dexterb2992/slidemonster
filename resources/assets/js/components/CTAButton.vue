<template>
    <a v-if="form.has_cta_button" :href="form.cta_button_url" v-text="form.cta_button_text"></a>
</template>

<script>
    export default {
        props: ['form']
    }

</script>