<template>
    <div class="slide-form-wrapper container">
        <div class="form-inner-wrapper">
            <div class="section">
                <h5 class="title">
                    Slides
                    <router-link to="/slides/create" class="btn btn-neutral btn-info pull-right">
                        <i class="fa fa-plus"></i> Create new
                    </router-link>
                </h5>
            </div>
            <div class="section">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(slide, key) in slides">
                            <td>{{ key+1 }}</td>
                            <td>{{ slide.title }}</td>
                            <td>
                                <router-link :to="`/slides/${slide.id}/edit`" class="btn btn-info">
                                    <i class="fa fa-edit"></i> Edit
                                </router-link>
                                <modal-trigger class="btn btn-warning" dataTarget="#viewCode">
                                    <i class="fa fa-code"></i> Code
                                </modal-trigger>
                                <a href="javascript:void(0)" class="btn btn-danger" :disabled="deleting" @click="deleteSlide(key)">
                                    <i class="fa fa-spin fa-refresh" v-if="deleting"></i>
                                    <i class="fa fa-trash" v-if="!deleting"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <tr v-if="slides.length < 1">
                            <td colspan="3">
                                You currently don't have any slides. 
                                <router-link :to="`/slides/create`">
                                    <i class="fa fa-plus"></i> Create new
                                </router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <modal id="viewCode" title="Client-side Code" isLarge="true">
                <p class="text-info">Add this code anywhere inside your html <code>&lt;body&gt;</code> tag.</p>
                <code>
                    &lt;script type="text/javascript" id="slidemonster" data-id="{{ selectedSlide.id }}" data-key="{{ apiToken }}" src="{{ app_url }}"&gt;&lt;/script&gt;
                </code>
            </modal>
        </div>
    </div>
</template>

<script>
    import {get, post, del} from '../../helpers/api';
    import Auth from '../../store/auth';
    import {handleErrorResponse, showErrorMsg, showSuccessMsg, showWarningMsg} from '../../helpers/helper';
    import ModalTrigger from '../../components/ModalTrigger.vue';
    import Modal from '../../components/Modal.vue';

    export default {
        data() {
            return {
                pageClass: 'page-index',
                slides: {},
                deleting: false,
                base_url: window.base_url,
                app_url: window.app_url,
                selectedSlide: {
                    id: 0
                },
                apiToken: Auth.state.api_token
            };
        },
        components: {
            'modal-trigger': ModalTrigger,
            'modal': Modal
        },
        mounted() {
            this.init();
            Event.fire('page-loaded', this.pageClass);
        },

        methods: {
            init() {
                get(base_url+'api/slides').then((res) => {
                    this.slides = res.data;
                    console.log(res);
                }, (err) => {
                    handleErrorResponse(err.response.status);
                });
            },
            showCode(key) {
                console.log(key);
            },

            deleteSlide(key) {
                if (confirm("Are you sure to delete this?")) {
                    var id = this.slides[key].id;

                    del(base_url+'api/slides/'+id).then((res) => {
                        if (res.data.success) {
                            showSuccessMsg(res.data.message);
                            this.slides.splice(key, 1);
                        } else {
                            showErrorMsg(res.data.message);
                        }
                    }, (err) => {
                        handleErrorResponse(err.response.status);
                    }, () => {
                        this.deleting = false;
                    });
                } 
                
            }
        }
    }
</script>