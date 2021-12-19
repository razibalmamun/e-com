<template>
    <form v-on:submit.prevent="formSubmitHandler" class="bg-white p-10 rounded-lg shadow-lg min-w-full" enctype="multipart/form-data">
        <div>
            <label class="text-gray-800 font-semibold block my-3 text-md" for="name">Name</label>
            <input v-model="form.name" class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="name" id="name" placeholder="name" />
            <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                {{$getValidationError(errors, 'name')}}
            </span>
        </div>
        
        <div>
            <label class="text-gray-800 font-semibold block my-3 text-md" for="description">Description</label>
            <input v-model="form.description" class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="description" id="description" placeholder="description" />
        </div>

        <div>
            <label class="text-gray-800 font-semibold block my-3 text-md" for="price">Price</label>
            <input v-model="form.price" class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="price" id="price" placeholder="price" />
            <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                {{$getValidationError(errors, 'price')}}
            </span>
        </div>

        <div>
            <label class="text-gray-800 font-semibold block my-3 text-md" for="quantity">Quantity</label>
            <input v-model="form.quantity" class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="text" name="quantity" id="quantity" placeholder="quantity" />
            <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                {{$getValidationError(errors, 'quantity')}}
            </span>
        </div>

        <div>
            <label class="text-gray-800 font-semibold block my-3 text-md" for="image">Image</label>
            <input @change="uploadImage" class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none" type="file" name="image" id="image" placeholder="image" />
        </div>
        

        <div class="inline-flex rounded-md shadow-sm" role="group">
            <button type="submit" class="w-full mt-6 bg-green-600 rounded-lg px-4 py-2 text-lg text-white tracking-wide font-semibold font-sans mr-2">Save</button>
            <NuxtLink :to="localePath('admin-products')" class="w-full mt-6 bg-red-600 rounded-lg px-4 py-2 text-lg text-white tracking-wide font-semibold font-sans">Close</NuxtLink>
        </div>
    </form>
</template>

<script>
export default {
    nane : "Products",
    props: {
        operation: String,
    },
    data: () => ({
        form: {
            name : '',
            description : '',
            price : '',
            quantity : '',
            status : 1,
            image : '',
        },      
        errors : null,    
    }),
    created() {
       console.log(this.$i18n);
    },
    mounted() {
        if (this.operation == 'create') {
            
        }
        if (this.operation == "edit") {
            this.initEdit();
        }
    },
    methods: {
        async initEdit() {
            let response = await this.$axios.$get("/v1/products/" + this.$route.params.id);
            this.form = {...this.form, ...response.data};
        },
        async formSubmitHandler() {
            if (this.operation == "create") {
                this.create();
            }
            if (this.operation == "edit") {
                this.update();
            }
        },
        async create() {
            try {
                let response = await this.$axios.$post("v1/products", this.form);
                if (response.success) {
                    this.$router.push(this.localePath("admin-products"));                   
                    this.$toast.clear();
                    this.$toast.success("Product created successfully");
                } else {
                    this.$toast.clear();
                    this.$toast.error("Operation Failed");
                }
            } catch (error) {
                this.errors = error.response.data.errors;
                this.$toast.clear();
                this.$toast.error("Operation Failed");
                setTimeout(() => {
                    this.$scrollTo(".error--text", {
                        offset: -100,
                    });
                }, 500);
            }
        },
        async update() {
            try {
                let response = await this.$axios.put("v1/products/" + this.$route.params.id, this.form);
                if (response) {
                    this.$router.push(this.localePath("admin-products"));
                    this.$toast.clear();
                    this.$toast.success("Product updated successfully");
                } else {
                    this.$toast.clear();
                    this.$toast.error("Operation Failed ss");
                }
            } catch (error) {
                this.errors = error.response.data.errors;
                this.$toast.clear();
                this.$toast.error("Operation Failed");
                setTimeout(() => {
                    this.$scrollTo(".error--text", {
                        offset: -100,
                    });
                }, 500);
            }
        },
        uploadImage(e) {
            let file = e.target.files[0];
            let reader = new FileReader();  
            reader.onloadend = (file) => {
                this.form.image = reader.result;
            }              
            reader.readAsDataURL(file);
        }
    },
};
</script>