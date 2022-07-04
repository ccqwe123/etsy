<template>
    <div class="container-fluid">
        <div class="row">
	        <div class="col-md-12 grid-margin">
	            <div class="row">
	                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
	                    <h3 class="font-weight-bold">Category List</h3>
	                </div>
	                <div class="col-12 col-xl-4">
	                    <div class="justify-content-end d-flex">
	                        <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
	                            <button class="btn btn-sm text-white btn-outline-primary bg-primary" type="button" data-toggle="modal" @click="loadModal"> Add Category <i class="icon-plus menu-icon"></i>
	                            </button>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="row">
	        <div class="col-md-12 grid-margin stretch-card">
	            <div class="card">
	                <div class="card-body">
	                    <div class="row">
	                        <div class="col-12">
	                            <div class="table-responsive">
	                                <table class="display expandable-table table table-bordered table-hover" style="width:100%">
	                                    <thead>
	                                        <tr>
	                                            <th>Category</th>
	                                            <th>Status</th>
	                                            <th></th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                        <tr v-for="category in categories.data" :key="category.id">
	                                            <td>{{ category.category_name }}</td>
	                                            <td v-if="category.status == 'active'"><span class="badge badge-pill badge-success">Active</span></td>
	                                            <td v-else><span class="badge badge-pill badge-danger">Inactive</span></td>
	                                            <td>
	                                            	<button class="btn btn-success btn-sm" alt="Edit" title="Edit" @click="editCategory(category)"><i class="fa-solid fa-pencil"></i></button>
                                        			<button class="btn btn-danger btn-sm" alt="Delete" title="Delete" @click="deleteCategory(category.id)"><i class="fa-solid fa-trash-can"></i></button>
	                                            </td>
	                                        </tr>
	                                    </tbody>
	                                </table>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="modal fade" id="add-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	        <div class="modal-dialog modal-dialog" role="document">
	            <div class="modal-content">
	                <form class="forms-sample" @submit.prevent="editmode ? updateCategory() : createCategory()">
	                <div class="modal-body">
	                    <div class="col-12 stretch-card">
	                        <div class="card">
	                            <div class="card-body">
	                                <h4 class="card-title">Add New Product</h4>
	                                    <div class="form-group">
	                                        <label for="category">Category</label>
	                                        <input type="text" name="category_name" v-model="form.category_name" class="form-control" id="category" placeholder="Category Name">
	                                        <HasError :form="form" field="category_name" />
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="status">Status</label>
	                                        <select class="form-control" id="status" name="status" v-model="form.status">
	                                            <option value="active" selected>Active</option>
	                                            <option value="inactive">Inactive</option>
	                                        </select>
	                                    </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer">
	                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
	                    <button type="submit" class="btn btn-primary">Save</button>
	                </div>
	                </form>
	            </div>
	        </div>
	    </div>
    </div>
</template>

<script>
    export default {
    	data() {
    		return {
    			form: new Form({
    				id:'',
    				category_name: '',
    				status: 'active',
    			}),
    			editmode: false,
    			categories: {},
    		}
    	},
        mounted() {
            $('.modal').hide();
            this.loadCategory();
        },
        methods: {
        	editCategory(category)
            {
                this.editmode = true;
                this.form.fill(category);
                $('#add-category').modal('show');
            },
        	loadCategory()
            {
              axios.get("api/category")
                .then(response => {
                    this.categories = response.data;
                    this.loading = false;
                });
            },
        	loadModal(){
                this.editmode = false;
                this.form.reset();
                $('#add-category').modal('show');
            },
        	createCategory() {
        		console.log("CReate");
                this.form.post('api/category')
                .then(response => {
                	$(".modal-backdrop").hide();
                    $('#add-category').modal('hide');
                    this.loadCategory();
                    toast.fire({
                      icon: 'success',
                      title: 'Category Successfully Added'
                    })
                })
            },
            updateCategory()
	        {
	        	console.log("UPDATE");
	            this.form.put('api/category/'+this.form.id)
	                .then(() => {
	                    // success
	                    $('#add-category').modal('hide');
	                     toast.fire(
	                        'Updated!',
	                        'Category has been updated.',
	                        'success'
	                        )
	                     this.loadCategory();
	                })
	                .catch((err) => {
	                    console.log(err);
	                });
	        },
	        deleteCategory(id)
            {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                this.form.delete('api/category/'+id).then(()=>{
                                        swal.fire(
                                        'Deleted!',
                                        'Category has been deleted.',
                                        'success'
                                        )
                                    this.loadCategory();
                                }).catch(()=> {
                                    swal("Failed!", "There was something wronge.", "warning");
                                });
                         }
                    })
            }
        }
    }
</script>
