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
                <table class="table table-bordered table-responsive">
                    <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subscription</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <tr v-for="(user, key) in filteredUsers" :key="key">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td>
                                <span class="badge badge-success" v-if="user.subscriptions.length > 0">Subscribed</span>
                                <span class="badge badge-default" v-if="user.subscriptions.length < 1">Free</span>
                            </td>
                            <td>
                                <a class="btn btn-info" @click="editUser(user)" href="javascript:void(0)">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <button type="button" class="btn btn-danger" @click="deleteUser(key)" :disabled="deleting">
                                    <i class="fa fa-trash" v-if="!deleting"></i>
                                    <i class="fa fa-spin fa-refresh" v-if="deleting"></i> Delete
                                </button>
                            </td>
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

        <modal :title="`${userToEdit.name} - Edit`" form-wrapper="form_user" id="editUserModal">
            <form class="form" role="form" id="form_user">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" v-model="userToEdit.name" class="form-control" @keyup.enter="updateUser">
                </div>
                <div class="for-group">
                    <label>Email</label>
                    <input type="email" v-model="userToEdit.email" class="form-control"  @keyup.enter="updateUser">
                </div>
            </form>
            <template slot="submit-button">
                <button class="btn btn-warning" type="button" :disabled="updating" @click="updateUser">
                    <i class="fa fa-check" v-if="!updating"></i>
                    <i class="fa fa-spin fa-refresh" v-if="updating"></i> Save Changes
                </button>
            </template>
        </modal>
    </div>
    
</template>
<script>
    import {get, del, post} from '../../helpers/api';
    import {showSuccessMsg, showErrorMsg, showInfoMsg, showWarningMsg, handleErrorResponse} from '../../helpers/helper';
    import Auth from '../../store/auth';
    import Paginate from 'vuejs-paginate';
    import Modal from '../../components/Modal';
    
    export default {
        components: {
            'paginate': Paginate,
            'modal': Modal
        },
        data() {
            return {
                pagination: {
                    current_page: 0,
                    last_page: 0
                },
                users: [],
                resource_url: `${base_url}api/users`,
                search: '',
                userToEdit: {
                    name: '',
                    email: ''
                },
                updating: false,
                deleting: false
            };
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
                });
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
            },
            editUser(user) {
                this.userToEdit = user;
                $("#editUserModal").modal('show');
            },
            deleteUser(index) {
                let userId = this.users[index].id;
                
                if (confirm("Are you really sure to delete this user? This cannot be undone.")) {
                    del(`${base_url}api/users/${userId}`).then(res => {
                        if (res.data.success) {
                            showSuccessMsg(res.data.message);
                            this.users.splice(index, 1);
                        } else {
                            showErrorMsg(res.data.message);
                        }
                    }).catch(err => {
                        showErrorMsg("Something went wrong while trying to delete this user.");
                        console.warn(err);
                    });
                }
            },

            updateUser() {
                this.updating = true;
                post(`${base_url}api/users/${this.userToEdit.id}/edit`, this.userToEdit).then(res => {
                    $("#editUserModal").modal('hide');
                    if (res.data.success) {
                        showSuccessMsg(res.data.message);
                    } else {
                        showErrorMsg(res.data.message);
                    }
                }).catch(err => {
                    showErrorMsg("Something went wrong while trying to update a user. Please try again later.");
                    console.warn(err);
                }).then(() => {
                    this.updating = false;
                });
            }
        }
    }
</script>