<template>
    <form v-on:submit.prevent="formSubmitHandler" class="bg-white p-10 rounded-lg shadow-lg min-w-full" enctype="multipart/form-data">
        <div>
            Customer : {{form.customer_name}}<br />
            Order Id : {{form.id}}<br />
            Order Total : {{form.order_total}}<br />
            Order Time : {{form.created_at}}
            <hr>
        </div>
    
        <div>
            <label class="text-gray-800 font-semibold block my-3 text-md" for="quantity">Order Details</label>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Product
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Price
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Quantity
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Sub Total
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <tr v-if="!form.details.length"><td colspan="5" class="px-6 py-4 whitespace-nowrap">products not available!</td></tr>	
                <tr v-for="(item, key) in form.details" :key="key">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ item.product_name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ item.price }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ item.quantity }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ item.sub_total }}</div>
                    </td>
                </tr>
                </tbody>
            </table>
            <hr>
        </div>

        <div>
            <label class="text-gray-800 font-semibold block my-3 text-md" for="quantity">Order Status</label>
            <select v-model="form.order_status" class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none">
                <option value="1">Approved</option>
                <option value="2">Rejected</option>
                <option value="3">Processing</option>
                <option value="4">Shipped</option>
                <option value="5">Delivered</option>
            </select>
        </div>        

        <div class="inline-flex rounded-md shadow-sm" role="group">
            <button type="submit" class="w-full mt-6 bg-green-600 rounded-lg px-4 py-2 text-lg text-white tracking-wide font-semibold font-sans mr-2">Save</button>
            <NuxtLink :to="localePath('admin-orders')" class="w-full mt-6 bg-red-600 rounded-lg px-4 py-2 text-lg text-white tracking-wide font-semibold font-sans">Close</NuxtLink>
        </div>
    </form>
</template>

<script>
export default {
    nane : "Orders",
    props: {
        operation: String,
    },
    data: () => ({
        form: {
            user_id : '',
            customer_name : '',
            order_total : '',
            order_status : '',
            details : [],
        },      
        errors : null,    
    }),
    created() {
       
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
            let response = await this.$axios.$get("/v1/admin/orders/" + this.$route.params.id);
            this.form = {...this.form, ...response.data};
        },
        async formSubmitHandler() {
            if (this.operation == "edit") {
                this.update();
            }
        },
        async update() {
            try {
                let response = await this.$axios.put("v1/admin/orders/" + this.$route.params.id, this.form);
                if (response) {
                    this.$router.push(this.localePath("admin-orders"));
                    this.$toast.clear();
                    this.$toast.success("Order updated successfully");
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
        }
    },
};
</script>