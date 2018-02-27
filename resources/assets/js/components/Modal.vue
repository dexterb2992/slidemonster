<template>
    <div class="modal" :id="`${id}`" tabindex="-1" role="dialog" :aria-labelledby="`${id}Label`" aria-hidden="true">
        <div :class="`modal-dialog ${isLarge ? 'modal-lg' : ''}`">
            <div class="modal-content">
                <!-- <a :href="link" :is="link ? 'a' : 'span'">Some text</a> -->
                <div :is="formWrapper ? 'form' : 'div'" :id="formWrapper">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" :id="`${id}Label`">{{ title }}</h4>
                    </div>
                    <div class="modal-body">
                        <slot></slot>
                        <slot name="modal-body"></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="close-button">
                            <button type="button" class="btn btn-default btn-simple pull-right" data-dismiss="modal">Close</button>
                        </slot>
                        <slot name="submit-button"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['title', 'id', 'isLarge', 'formWrapper'],
        data() {
            return {
                submitButton: ''
            }
        }
    }
</script>