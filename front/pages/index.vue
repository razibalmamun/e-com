<template>
  <div>
      <ProductsList />
  </div>
</template>

<script>
import ProductsList from '@/components/ProductsList';
import { mapState } from "vuex";
export default {
  name: 'Home',
  layout : 'front',  
  auth: false,
  components: {
      ProductsList
  },
  computed: {
     
  },
  data() {
		return {
			loading: false,
		};
	},
  mounted() {
		
	},
  methods: {
		
	},
}
</script>
