<template>
    <div class="container-fluid">
        <div class="row">
	        <div class="col-md-12 grid-margin">
	            <div class="row">
	                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
	                    <h3 class="font-weight-bold">Product List</h3>
	                </div>
	                <div class="col-12 col-xl-4">
	                    <div class="justify-content-end d-flex">
	                        <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
	                            <button class="btn btn-sm text-white btn-outline-primary bg-primary" type="button" data-toggle="modal" data-target="#add-product"> Add Product <i class="icon-plus menu-icon"></i>
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
	                                            <th width="6%" height="20%">Product Image</th>
	                                            <th>Product Name</th>
	                                            <th>Price</th>
	                                            <th>Profit</th>
	                                            <th>Category</th>
	                                            <th>Store</th>
	                                            <th>Status</th>
	                                            <th></th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                        <tr v-for="(product,index) in products.data" :key="product.id" class="font-weight-bold">
	                                            <td align="center"><img class="img-thumbnail" :src="product.thumbnail ? 'images/products/'+ product.thumbnail : 'images/products/default.jpg'"></td>
	                                            <td style="text-align:center">Lorem parabum asdasd sad asdasdasdasdasLorem parabum asdasd sad asdasdasdasdasLorem parabum asdasd sad asdasdasdasdasLorem parabum asdasd sad asdasdasdasdasLorem parabum asdasd sad asdasdasdasdas
	                                            Lorem parabum asdasd sad asdasdasdasdasLorem parabum asdasd sad asdasdasdasdas</td>
	                                            <!-- <td style="text-align:center">{{ product.product_name }}</td> -->
	                                            <td style="text-align:center">${{ product.price }}</td>
	                                            <td style="text-align:center">{{ product.profit ? '$'+ product.profit : "test" }}</td>
	                                            <td style="text-align:center">{{ product.categories ? product.categories.category_name : "No Category" }}</td>
	                                            <td style="text-align:center">{{ product.store }}</td>
	                                            <td v-if="product.status == 'active'"><span class="badge badge-pill badge-success">Active</span></td>
	                                            <td v-else><span class="badge badge-pill badge-danger">Inactive</span></td>
	                                            <td>
	                                            	<button class="btn btn-primary btn-sm" alt="Edit" title="Store"><i class="fa-solid fa-store"></i></button>
	                                            	<button class="btn btn-success btn-sm" alt="Edit" title="Supplier"><i class="fa-solid fa-up-right-from-square"></i></button>
	                                            	<button class="btn btn-warning btn-sm" alt="Edit" title="Edit"><i class="fa-solid fa-pencil"></i></button>
	                                            	<button class="btn btn-danger btn-sm" alt="Edit" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
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
	    <div class="modal fade" id="add-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	        <div class="modal-dialog" role="document">
	            <div class="modal-content">
	            	<form @submit.prevent="editmode ? updateProduct() : createProduct()">
	                <div class="modal-body">
	                    <div class="col-12 stretch-card">
	                        <div class="card">
	                            <div class="card-body">
	                                <h4 class="card-title">Add New Product</h4>
	                                    <div class="form-group">
	                                        <label for="exampleInputPassword4">Store</label>
	                                        <select class="form-control" v-model="form.store">
		                                        <option value="" disabled>Select Store</option>
		                                        <option value="Etsy">Etsy</option>
		                                        <option value="Amazon">Amazon</option>
		                                        <option value="Bonanza">Bonanza</option>
		                                        <option value="Other">Other</option>
		                                    </select>
		                                    <HasError :form="form" field="store" />
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Thumbnail</label>
	                                        <input type="file" name="img[]" class="file-upload-default" accept=".jpg,.jpeg,.png,.gif" @change="onInputChange">
	                                        <div class="input-group col-xs-12">
	                                            <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
	                                            <span class="input-group-append">
	                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
	                                            </span>
	                                        </div>
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="exampleInputName1">Product Name</label>
	                                        <input type="text" v-model="form.product_name" class="form-control" id="exampleInputName1" placeholder="Product Name">
	                                        <HasError :form="form" field="product_name" />
	                                    </div>
	                                    <div class="form-group frmcat">
	                                        <label for="exampleInputPassword4">Category</label>
	                                        <select class="form-control" v-model="form.category_id" v-if="!addsection" @change="addSect">
		                                        <option value="" disabled>Select Category</option>
		                                        <option v-for="category in categories" :key="category.id" v-bind:value="category.id">{{category.category_name}}</option>
		                                        <optgroup label="Couldn't find section?">
											      <option value="">Add Section</option>
											    </optgroup>
		                                    </select>
		                                    <div class="input-group" v-else>
											  <input type="text" v-model="form.category_name" class="form-control search-query" placeholder="Recipient's username" aria-label="Section Title" aria-describedby="basic-addon2">
											  <span class="input-group-btn">
											    <button class="btn btn-outline-secondary" type="button" title="Cancel" @click="removeSec">X</button>
											  </span>
											</div>
											<HasError :form="form" field="category_name" />
											<HasError :form="form" field="category_id" />
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="exampleInputPassword4">Product Price</label>
	                                        <div class="input-group">
	                                            <div class="input-group-prepend">
	                                                <span class="input-group-text bg-primary text-white">$</span>
	                                            </div>
	                                            <input type="text" v-model="form.price" placeholder="0.00" class="form-control">
	                                            <div class="input-group-append"></div>
	                                        </div>
	                                        <HasError :form="form" field="price" />
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="exampleInputPassword4">Profit</label>
	                                        <div class="input-group">
	                                            <div class="input-group-prepend">
	                                                <span class="input-group-text bg-primary text-white">$</span>
	                                            </div>
	                                            <input type="text" v-model="form.profit" placeholder="0.00" class="form-control">
	                                            <div class="input-group-append"></div>
	                                        </div>
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="exampleInputCity1">Product Link <i>(optional)</i>
	                                        </label>
	                                        <input type="text" v-model="form.product_link" class="form-control" id="exampleInputCity1" placeholder="Location">
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="exampleInputCity1">Supplier Link</label>
	                                        <input type="text" v-model="form.supplier_link" class="form-control" id="exampleInputCity1" placeholder="Location">
	                                        <HasError :form="form" field="supplier_link" />
	                                    </div>
	                                    <div class="form-group">
	                                        <label for="status">Status</label>
	                                        <select class="form-control" id="status" v-model="form.status">
	                                            <option value="active" selected>Active</option>
	                                            <option value="inactive">Inactive</option>
	                                        </select>
	                                        <HasError :form="form" field="status" />
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
<style type="text/css" scoped>
	table tr td{
		font-family: 'Rubik', sans-serif;
	}
	.input-group-prepend
	{
		height: 37px !important;
	}
	.frmcat .search-query {
    width:100%;
    padding-right: 3px;
    padding-left: 15px;
        /* IE7-8 doesn't have border-radius, so don't indent the padding */
    margin-bottom: 0;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 0;
}
 
.frmcat button {
    border: 0;
    background: none;
    /** belows styles are working good */
    padding: 4px 6px;
    margin-top: 2px;
    position: absolute;
    right:0;
    margin-bottom: 0;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    cursor: unset;
    z-index: 2;
}
 
.search-query:focus{
    z-index: 0;   
}
button.btn.btn-outline-secondary:hover {
    background-color: transparent !important;
    color: black;
    outline: #cba200;
}
.expandable-table tr td {
    padding: 5px 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 50ch;
    text-align: center;

    line-height: 16px;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.table td img, .jsgrid .jsgrid-table td img {
    width: 80px;
    height: 80px;
    border-radius: 0%;
}
.table th, .table td {
	vertical-align: unset!important;
}
</style>
<script>
    export default {
    	data() {
    		return {
    			form: new Form({
    				id:'',
    				product_name: '',
    				price: '',
    				profit: '',
    				thumbnail: '',
    				store: '',
    				product_link: '',
    				supplier_link: '',
    				category_id: '',
    				status: 'active',
    				category_name:null,
    			}),
    			editmode: false,
    			products: {},
                categories: {},
                addsection: false,
    		}
    	},
        mounted() {
            this.loadProducts();
            this.loadCategory();
        },
        methods: {
        	removeSec() {
        		this.form.category_name = null;
        		this.addsection = false;
        	},
        	addSect() {
        		if(this.form.category_id == '')
        		{
        			this.form.category_name = null;
        			this.addsection = true;
        		}else{
        			this.addsection = false;
        		}
        	},
        	onInputChange(e) {
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.onloadend = (file) => {
                	this.form.thumbnail = reader.result;
                }
                reader.readAsDataURL(file);
            },
        	loadProducts()
        	{
        		axios.get("api/product")
                .then(response => {
                    this.products = response.data;
                    console.log(response.data);
                });
        	},
        	loadCategory()
            {
                axios.get("api/category/fetch/data")
                .then(response => {
                    this.categories = response.data;
                });
            },
            createProduct()
            {
                 this.form.post('api/product')
                    .then(response => {
                        $('#add-product').modal('hide');
                        // this.loadProducts();
                        toast.fire({
                          icon: 'success',
                          title: 'Product Successfully Added'
                        })
                    })
            },
        }
    }
</script>
