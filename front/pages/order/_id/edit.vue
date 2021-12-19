<template>
    <div>
		<div class="bg-gray-800 pt-3">
			<div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
				<h3 class="font-bold pl-2"><span>Order Details</span></h3>
			</div>
		</div>

		<!---Table-->
		<div class="flex flex-col p-2">
			<div class="bg-white p-10 rounded-lg shadow-lg min-w-full">
                <div>
                    Customer : {{order.customer_name}}<br />
                    Order Id : {{order.id}}<br />
                    Order Total : {{order.order_total}}<br />
                    Order Time : {{order.created_at}}<br />
                    Order Status : <span v-if="order.order_status == 1" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Approved
                    </span>
                    <span v-else-if="order.order_status == 2" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Rejected
                    </span>
                    <span v-else-if="order.order_status == 3" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Processing
                    </span>	
                    <span v-else-if="order.order_status == 4" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Shipped
                    </span>	
                    <span v-else-if="order.order_status == 5" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        Delivered
                    </span>	
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
                        <tr v-if="!order.details.length"><td colspan="5" class="px-6 py-4 whitespace-nowrap">products not available!</td></tr>	
                        <tr v-for="(item, key) in order.details" :key="key">
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
            </div>
        </div>
    </div>
</template>

<script>
export default {
    layout : 'front',
    data: () => ({
        order: {
            user_id : '',
            customer_name : '',
            order_total : '',
            order_status : '',
            details : [],
        },         
    }),
    mounted() {
        this.initView();
    },
    methods: {
        async initView() {
            let response = await this.$axios.$get("/v1/orders/" + this.$route.params.id);
            this.order = {...this.order, ...response.data};
        },
    },
}
</script>