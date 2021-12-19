<template>
	<div>
		<div class="bg-gray-800 pt-3">
			<div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
				<h3 class="font-bold pl-2"><span>Orders</span></h3>
			</div>
		</div>

		<!---Table-->
		<div class="flex flex-col p-2">
			<div class="bg-white p-10 rounded-lg shadow-lg min-w-full">				
				<div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 mt-2">
					<button v-on:click="[(search = ''), loadOrders()]" class='relative bg-green-500 text-white p-1 rounded font-bold overflow-hidden'>Refresh</button>
					<div class="mt-5 shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
						<table class="min-w-full divide-y divide-gray-200">
							<thead class="bg-gray-50">
							<tr>
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
									Order ID
								</th>

								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
									Customer
								</th>

								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
									Total Order
								</th>

								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
									Status
								</th>
								
								<th scope="col" class="relative px-6 py-3">
									<span class="sr-only">View</span>
								</th>
							</tr>
							</thead>
							<tbody class="bg-white divide-y divide-gray-200">
							<tr v-if="!orders.length"><td colspan="5" class="px-6 py-4 whitespace-nowrap">Order not available!</td></tr>	
							<tr v-for="(order, key) in orders" :key="key">
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-gray-900">{{ order.id }}</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-gray-900">{{ order.customer_name }}</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-gray-900">{{ order.order_total }}</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<span v-if="order.order_status == 1" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
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
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
									<NuxtLink :to="localePath({name: 'order-id-edit', params: {id: order.id}})" class="text-indigo-600 hover:text-indigo-900">View</NuxtLink>
									<a href="#" @click="deleteRecord(order.id, key)">Delete</a>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!---Table END--->
		<vue-confirm-dialog></vue-confirm-dialog>
	</div>
</template>

<script>
export default {
  	layout : 'front',
	data() {
		return {
			loading: false,
			search: "",
			orders: [],
		};
	},
	components: {
		
	},
	watch: {
		
	},
	mounted() {
		this.loadOrders();
	},
	methods: {
		async loadOrders() {
			this.loading = true;
			this.orders = [];
			await this.$axios
				.$get("/v1/orders", {
					params: {
						search: this.search,
					},
				})
				.then((response) => {
					if(response) {
						this.orders = response.data;
					}
				})
				.catch(
					function (error) {
						console.log(error);
					}.bind(this)
				);
			this.loading = false;
		},
		deleteRecord(deleteId, index) {
			this.$confirm(
				{
				message: 'Do you confirm to delete this entry?',
				button: {
					no: 'No',
					yes: 'Yes'
				},
				callback: confirm => {
					if (confirm) {
						this.$axios.delete("/v1/orders/" + deleteId).then((response) => {
							if (response) {
								this.orders.splice(index, 1);
								this.$toast.clear();
								this.$toast.success("Order deleted successfully");
							}
						})
						.catch((error) => {
							this.$toast.error("Operation Failed");
						});
					}
				}
				}
			)
		},
	},
};
</script>
