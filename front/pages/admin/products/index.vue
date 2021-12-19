<template>
	<div>
		<div class="bg-gray-800 pt-3">
			<div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
				<h3 class="font-bold pl-2"><span>Products</span></h3>
			</div>
		</div>

		<!---Table-->
		<div class="flex flex-col p-2">
			<div class="bg-white p-10 rounded-lg shadow-lg min-w-full">				
				<div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 mt-2">
					<NuxtLink :to="localePath('admin-products-create')" class='relative bg-blue-500 text-white p-2 rounded font-bold overflow-hidden'>Add New</NuxtLink>
					<button v-on:click="[(search = ''), loadProducts()]" class='relative bg-green-500 text-white p-1 rounded font-bold overflow-hidden'>Refresh</button>
					<div class="mt-5 shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
						<table class="min-w-full divide-y divide-gray-200">
							<thead class="bg-gray-50">
							<tr>
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
									<input type="text" v-on:keyup="loadProducts" v-model="search" placeholder="Search by name..." class="w-full bg-gray-100 px-4 py-2 rounded-lg focus:outline-none"/>
								</th>

								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
									Price
								</th>

								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
									Quantity
								</th>

								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
									Stock
								</th>

								<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
									Status
								</th>
								
								<th scope="col" class="relative px-6 py-3">
									<span class="sr-only">Edit</span>
								</th>
							</tr>
							</thead>
							<tbody class="bg-white divide-y divide-gray-200">
							<tr v-if="!products.length"><td colspan="5" class="px-6 py-4 whitespace-nowrap">Product not available!</td></tr>	
							<tr v-for="(product, key) in products" :key="key">
								<td class="px-6 py-4 whitespace-nowrap">
								<div class="flex items-center">
									<div class="flex-shrink-0 h-10 w-10">
										<img class="h-10 w-10 rounded-full" :src="$config.remoteBaseUrl+'/storage/'+product.image" alt="" />
									</div>
									<div class="ml-4">
										<div class="text-sm font-medium text-gray-900">
											{{ product.name }}
										</div>
										<div class="text-sm text-gray-500">
											{{ product.description }}
										</div>
									</div>
								</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-gray-900">{{ product.price }}</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-gray-900">{{ product.quantity }}</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<span v-if="product.quantity > 0" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
										In stock
									</span>
									<span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
										Out of Stock
									</span>
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<span v-if="product.status == 1" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
										Active
									</span>
									<span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
										Disable
									</span>
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
									<NuxtLink :to="localePath({name: 'admin-products-id-edit', params: {id: product.id}})" class="text-indigo-600 hover:text-indigo-900">Edit</NuxtLink>
									<a href="#" @click="deleteRecord(product.id, key)">Delete</a>
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
	data() {
		return {
			loading: false,
			search: "",
			products: [],
		};
	},
	components: {
		
	},
	watch: {
		
	},
	mounted() {
		this.loadProducts();
	},
	methods: {
		async loadProducts() {
			this.loading = true;
			this.products = [];
			await this.$axios
				.$get("/v1/products", {
					params: {
						search: this.search,
					},
				})
				.then((response) => {
					if(response) {
						this.products = response.data;
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
						this.$axios.delete("/v1/products/" + deleteId).then((response) => {
							if (response) {
								this.products.splice(index, 1);
								this.$toast.clear();
								this.$toast.success("Product deleted successfully");
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
