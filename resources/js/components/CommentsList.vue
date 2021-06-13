<template>
    <div>
        <ul class="tasks-list">
            <button class="btn btn-success" @click="newCondolenceModal()">Add condolence <i class="fas fa-user-plus fa-fw"></i></button>
            <br><br>
            <div v-for="comment in comments" :key="comment.id" class="mb-4">

                <li v-bind:id="'comments-'+ comment.id" class="media">
                    <img class="mr-4" src="https://www.gravatar.com/avatar/663ef5357412bd44667c93f6f05586e9.jpg?s=64" v-if="comment.commenter" :alt="comment.commenter.name">
                    <img class="mr-4" src="https://www.gravatar.com/avatar/663ef5357412bd44667c93f6f05586e9.jpg?s=64" v-else :alt="comment.guest_name">

                    <div class="media-body">
                        <h5 class="mt-0 mb-1" v-if="comment.commenter">{{comment.commenter.name}}<small class="text-muted"> - {{ comment.created_at | moment("from", "now") }}</small></h5>
                        <h5 v-else>{{comment.guest_name}}<small class="text-muted"> - {{ comment.created_at | moment("from", "now") }}</small></h5>
                        <div style="white-space: pre-wrap;">{{comment.comment}}</div>
                        <a href="#" v-if="is_admin" @click="deletePost(comment.id)" class="btn btn-sm btn-link text-danger text-uppercase">Delete</a>
                        <br />   
                    </div>
                
                </li>

            </div>


            <div class="modal fade" id="addModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form @submit.prevent="createCondolence">
                            <div class="modal-header">
                                <h5 class="modal-title">Book of Condolences</h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label for="message">Message</label>
                                        <div class="input-group">
                                            <textarea v-model="form.message" name="message" class="form-control" placeholder="Enter your message here" required rows="3"></textarea>
                                            <div class="invalid-feedback" style="width: 100%;">
                                                Your message is required.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Full name</label>
                                            <input v-model="form.fullname" name="fullname"  type="text" class="form-control" placeholder="" value="" required>
                                            <div class="invalid-feedback">
                                                Valid name is required.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="relationship">Relationship to deceased</label>
                                            <input v-model="form.relationship" name="relationship" type="text" class="form-control" placeholder="" value="" required>
                                            <div class="invalid-feedback">
                                                Valid Relationship is required.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input v-model="form.email" name="email" type="email" class="form-control" placeholder="you@example.com">
                                        <div class="invalid-feedback">
                                            Please enter a valid email address.
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address">Address</label>
                                        <input v-model="form.address" name="address" type="text" class="form-control" id="address" placeholder="1234 Main St" required>
                                        <div class="invalid-feedback">
                                            Please enter your address.
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-outline-secondary text-uppercase" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-sm btn-outline-success text-uppercase" @click="postCondolence()">Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </ul>

    </div>
</template>


<script>
    Vue.use(require('vue-moment'));
    import axios from "axios";
    import Form from 'vform';

    export default {
        
        props: ['post_id', 'is_admin'],
        mounted() {             
            this.getComments();
        },
        data() {
            return {
                token: '{{ csrf_token() }}',
                comments: [],
                isLoading: false,
                form: new Form ({
                    message: '',
                    fullname: '',
                    relationship: '',
                    email: '',
                    address: '',
                    post_id: 0,
                    comment_id: 0
                })
            }
        },
        methods: {
            getComments(){
                axios.get('/obituary/'+this.post_id+'/comments')
                .then(response => {            
                    this.comments = response.data
                })
            },
            
            newCondolenceModal(){
                console.log("in newCondolenceModal")
                $('#addModal').modal('show');
            },
            postCondolence(){
                if (this.validateInputs()){
                    this.form.post_id = this.post_id;
                    this.form.post('saveCondolence').then(response => {
                        console.log(response.data.message);
                        
                        if (response.data.resp_code == '000') {
                            this.getComments();
                            $('#addModal').modal('hide');
                            Toast.fire({ icon: 'success',  title: response.data.resp_desc });
                        } else {
                            Toast.fire({ icon: 'error',  title: response.data.resp_desc });
                        }
                        this.form.reset();
                        
                    }).catch(e => {
                        // eslint-disable-next-line no-console
                        console.log(e);
                        this.isLoading = false;
                    });

                }
            },

            deletePost(comment_id){
                this.form.comment_id = comment_id;
                this.form.post('deleteCondolence').then(response => {
                    
                    if (response.data.resp_code == '000') {
                        this.getComments();
                        Toast.fire({ icon: 'success',  title: response.data.resp_desc });
                    } else {
                        Toast.fire({ icon: 'error',  title: response.data.resp_desc });
                    }
                    
                }).catch(e => {
                    // eslint-disable-next-line no-console
                    console.log(e);
                    this.isLoading = false;
                });
            },

            validateInputs(){
                
                console.log(this.form.message);
                if (this.form.message.length < 1) {
                    Toast.fire({ icon: 'error',  title: 'Please fill out all inputs' })
                    return;
                }

                return true;
            }
        }
    }
</script>
