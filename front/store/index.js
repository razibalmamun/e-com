let cart = window.localStorage.getItem('cart');
let cartCount = window.localStorage.getItem('cartCount');

export const state = () => ({
  drawer: true,
  selectedLang:'en',

  cart: cart ? JSON.parse(cart) : [],
  cartCount: cartCount ? parseInt(cartCount) : 0,
})

export const mutations = {
  toggleDrawer(state) {
    state.drawer = !state.drawer;
  },
  drawer(state, val) {
    state.drawer = val;
  },
  setLang(state,val){
    state.selectedLang=val;
  },
  addToCart(state, item) {
      let found = state.cart.find(product => product.id == item.id);
      if (found) {
          found.quantity ++;
          found.sub_total = found.quantity * found.price;
      } else {
          state.cart.push(item);
      }
      state.cartCount++;
  },
  removeFromCart(state, item) {
      let index = state.cart.indexOf(item);
      if (index > -1) {
          let product = state.cart[index];
          state.cartCount -= product.quantity;

          state.cart.splice(index, 1);
      }
  },
  removeCart(state) {
    state.cart = [];
  },
  saveCart(state) {
      window.localStorage.setItem('cart', JSON.stringify(state.cart));
      window.localStorage.setItem('cartCount', state.cartCount);
  }
}
