<template>
    <div class="slide-form-wrapper container">
        <div class="form-inner-wrapper">
            <div class="section">
                <h5 class="title">
                    Users
                    <!-- <router-link to="/slides/create" class="btn btn-neutral btn-info pull-right">
                        <i class="fa fa-plus"></i> Create new
                    </router-link> -->
                </h5>
            </div>

            <div class="section">
                <div class="form-inline form-group pull-right">
                    <input type="text" class="form-control" placeholder="Search..." v-model="search">
                </div>
                <table class="table table-bordered">
                    <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subscription Status</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <tr v-for="(user, key) in filteredUsers" :key="key">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
                                <nav v-if="pagination.last_page > 0">
                                    <paginate 
                                        container-class="pagination pagination-primary pull-right"
                                        page-class="page-item" 
                                        page-link-class="page-link"
                                        :pageCount="pagination.last_page"
                                        next-text='❯❯'
                                        prev-text='❮❮'
                                        prev-class="page-item"
                                        next-class="page-item"
                                        prev-link-class="page-link"
                                        next-link-class="page-link"
                                        :clickHandler="getUsers" v-cloak="`loading..`">
                                    </paginate>
                                </nav>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
</template>
<script>
    import {get} from '../../helpers/api';
    import {showSuccesMsg, showErrorMsg, handleErrorResponse} from '../../helpers/helper';
    import Auth from '../../store/auth';
    import Paginate from 'vuejs-paginate';
    
    export default {
        components: {
            'paginate': Paginate
        },
        data() {
            return {
                pagination: {
                    current_page: 0,
                    last_page: 0
                },
                users: [],
                resource_url: `${base_url}api/users`,
                search: ''
            }
        },
        mounted() {
            Event.fire('page-loaded', 'page-index');
            this.getUsers(1);
        },
        computed: {
            filteredUsers() {
                return this.users.filter(user => {
                    return user.name.toLowerCase().includes(this.search.toLowerCase()) ||
                        user.email.toLowerCase().includes(this.search.toLowerCase());
                })
            }
        },
        methods: {
            getUsers(page) {
                get(`${this.resource_url}?page=${page}`, {page: page}).then((res) => {
                    this.pagination = res.data;
                    this.users = this.pagination.data;
                }, (err) => {
                    handleErrorResponse(err.response.status);
                });
            }
        }
    }
</script>