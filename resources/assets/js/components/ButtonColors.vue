<template>
    <div>
        <span v-for="(buttonColor, key) in buttonColors" :key="key" class="col-md-8">
            <a :class="'btn '+buttonColor" @click="form.button_color = buttonColor" href="javascript:void(0)">
               <i class="fa fa-check" v-if="form.button_color == buttonColor"></i> {{ key }}
            </a>
        </span>
    </div>
</template>

<script>
    export default {
        props: ['form'],
        data() {
            return {
                buttonColors: {
                    red: 'btn-danger',
                    blue: 'btn-info',
                    green: 'btn-success',
                    orange: 'btn-warning',
                    primary: 'btn-primary',
                    white: 'btn-neutral',
                    gray: 'btn-default'
                },
            }
        }
    }
</script>