<template>
    <div>
        <span v-for="(buttonStyle, key) in buttonStyles" :key="key" class="col">
            <a :class="'btn '+form.button_color+' '+buttonStyle" @click="form.button_style = buttonStyle"  href="javascript:void(0)">
                <i class="fa fa-check" v-if="form.button_style == buttonStyle"></i> {{ key }}
            </a>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['form'],
        data() {
            return {
                buttonStyles: {
                    normal: 'btn',
                    round: 'btn-round',
                    simple: 'btn-simple',
                    hybrid: 'btn-round btn-simple'
                }
            }
        }
    }
</script>