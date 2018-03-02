<template>
    <div :class="!!editMode ? 'bootstrap-tagsinput' : ''" :is="!!editMode ? 'div' : 'ul'">
        <span :is="!!editMode ? 'span' : 'li'" :class="!!editMode ? 'tag badge badge-info' : ''" v-for="(feature, key) in features">{{ feature.content }}
            <span data-role="remove" v-if="!!editMode" @click="deleteFeature(key)"></span>
        </span>

        <span :is="!!editMode ? 'span' : 'li'" :class="!!editMode ? 'tag badge badge-danger' : ''" v-if="plan.trial_period_days > 0">
            {{ plan.trial_period_days }} Days Free Trial
        </span>
    </div>
</template>

<script>
    import {get, del, post} from '../helpers/api';
    import {showSuccessMsg, showErrorMsg, handleErrorResponse} from '../helpers/helper';

    export default {
        props: ['plan', 'editMode'],
        data() {
            return {
                base_url: window.base_url,
                features: []
            }
        },
        mounted() {
            get(`${this.base_url}api/plans/${this.plan.id}/features`).then((res) => {
                this.features = res.data;
            }, (err) => {
                console.err(err);
            });

            Event.listen('featureCreated', (feature) => {
                if (this.plan.id == feature.plan_id) {
                    this.features.push(feature);
                }
            });
        },
        methods: {
            deleteFeature(key) {
                let feature = this.features[key];
                del(this.base_url+'api/features/'+feature.id).then((res) => {
                    if (res.data.success) {
                        this.features.splice(key, 1);
                        showSuccessMsg(res.data.message);
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