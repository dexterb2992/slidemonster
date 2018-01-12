<template>
    <div>
        
    </div>
</template>

<script>
    import {get, post} from '../../helpers/api';
    import {showErrorMsg, handleErrorResponse} from '../../helpers/helper';

    export default {
        data() {
            return {
                pageClass: 'page-index',
                form: []
            };
        },

        mounted() {
            this.init();
        },

        methods: {
            init() {
                Event.fire('page-loaded', this.pageClass);
                get(this.$router.base+'api/slides/form').then((res) => {
                    if (res.data.success) {
                        this.form = res.data.form;
                    } else {
                        if (res.data.hasOwnProperty('message')) {
                            showErrorMsg(res.data.message);
                        }
                    }
                }, (err) => {
                    handleErrorResponse(err.response.status);
                });
            }
        }
    }
</script>