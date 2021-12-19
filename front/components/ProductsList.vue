<template>
    <div class="h-screen bg-gray-300">
      <div class="py-12">
          <div class="max-w-md mx-auto bg-gray-100 shadow-lg rounded-lg md:max-w-5xl">
              <div class="md:flex ">
                  <div class="w-full p-4 px-5 py-5">
                      <div class="md:grid md:grid-cols-3 gap-2 ">
                          <div class="col-span-2 p-5">
                              <h1 class="text-xl font-medium ">Products</h1>
                              <div v-for="product in products" :key="product.id" class="flex justify-between items-center mt-6 pt-6">
                                  <div class="flex items-center"> <img :src="$config.remoteBaseUrl+'/storage/'+product.image" :alt="product.name" width="60" class="">
                                      <div class="flex flex-col ml-3"> <span class="md:text-md font-medium">{{ product.name }}</span> <span class="text-xs font-light text-gray-400">{{ product.description }}</span> </div>
                                  </div>
                                  <div class="flex justify-center items-center">                                      
                                      <div class="pr-8 flex"> <span class="text-xs font-medium">${{ product.price }}</span> </div>
                                      <div class="pr-8"><button @click="addToCart(product)" type="button" class="w-full mt-1 bg-green-600 py-2 text-sm text-white mr-2 pl-2 pr-2">+</button></div>
                                      <div> <i class="fa fa-close text-xs font-medium"></i> </div>
                                  </div>
                              </div>                  
                          </div>

                          <Cart/>                          
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import Cart from '@/components/Cart';
export default {
    nane : "Products-List",
    props: {
        
    },
    components: {
        Cart
    },
    data() {
      return {
        loading: false,
        products: [],
      };
    },
    mounted() {
      this.loadProducts();
    },
    computed: {
        
    },
    methods: {
      addToCart(item) {          
          this.$set(item, 'quantity', 1);
          this.$set(item, 'sub_total', item.price);
          this.$store.commit('addToCart', item);
          this.$store.commit("saveCart");          
      },
      async loadProducts() {
        this.loading = true;
        this.products = [];
        await this.$axios.$get("/v1/catalog/products", {
            params: {
              search: this.search,
            },
        }).then((response) => {
            if(response) {
              this.products = response.data;
            }
        }).catch(
            function (error) {
              console.log(error);
            }.bind(this)
        );
        this.loading = false;
      },
    },
};
</script>