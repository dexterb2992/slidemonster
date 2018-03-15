<template>
    <div>
        <span v-for="(buttonSize, key) in buttonSizes" :key="key" class="col">
            <a :class="'btn '+form.button_style+' '+form.button_color+' '+buttonSize" @click="form.button_size = buttonSize"  href="javascript:void(0)">
                <i class="fa fa-check" v-if="form.button_size == buttonSize"></i> {{ key }}
            </a>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['form'],
        data() {
            return {
                buttonSizes: {
                    small: 'btn-sm',
                    medium: 'btn-md',
                    large: 'btn-lg'
                },
            }
        }
    }
</script>