<template>
    <div class=" p-5 bg-gray-800 rounded overflow-visible"> <span class="text-xl font-medium text-gray-100 block pb-1">Card Details</span>
        <template v-if="$store.state.cart.length > 0">
            <div v-for="item in $store.state.cart" :key="item.id" class="flex justify-center flex-col pt-1"> 
                <label class="text-xs text-gray-400 ">
                    <span class="removeBtn" title="Remove from cart" @click.prevent="removeFromCart(item)">X</span>
                    {{ item.name }} x {{ item.quantity }} - ${{ item.sub_total }}
                </label>
            </div>
            <button @click="checkout" class="mt-2 h-12 w-full bg-blue-500 rounded focus:outline-none text-white hover:bg-blue-600">Place Order ${{ totalPrice }}</button>
        </template>
        <template v-else>
            <div class="flex justify-center flex-col pt-1"> 
                <label class="text-xs text-gray-400 ">
                    Cart is empty
                </label>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    nane : "Cart",
    props: {
        
    },
    data() {
      return {
          form : {
              user_id : this.$auth.user ? this.$auth.user.id : 0,
              order_total : 0,
              order_status : 1,
              details : [],
          }
      };
    },
    mounted() {
      
    },
    computed: {
        totalPrice() {
            let total = 0;
            for (let item of this.$store.state.cart) {
                total += parseFloat(item.sub_total);
            }
            return total.toFixed(2);
        }
    },
    created() {
        console.log(!this.$auth.user);
        // console.log(this.$auth.user.id === null);
    },
    methods: {
      removeFromCart(item) {
          this.$store.commit('removeFromCart', item);
          this.$store.commit("saveCart"); 
      },
      async checkout() {
        if(this.$auth.user) {
            let products = this.$store.state.cart.map((val) => {
                return {
                    product_id: val.id,
                    price : val.price,
                    quantity : val.quantity,
                    sub_total : val.sub_total
                };
            });
            this.$set(this.form, 'order_total', this.totalPrice);
            this.$set(this.form, 'details', products);
            let response = await this.$axios.$post("v1/orders", this.form);
            if(response) {
                this.$store.commit('removeCart');
                this.$store.commit("saveCart");
                this.$toast.clear();
                this.$toast.success("Successfully placed your order");
            }
        } else {
            this.$toast.clear();
            this.$toast.error("Please signin before place to order");
            this.$router.push(this.localePath("user-auth-signin")); 
        }
      },
    },
};
</script>
<style>
.removeBtn {
    margin-right: 1rem;
    color: red;
    cursor: pointer;
}
</style>