<template>
    <div class="container">
        <div class="flex flex-col md:flex-row">
            <div class="main-content flex-1 bg-gray-100 pb-24 md:pb-5">
                <div class="bg-white">
                    <nav class="flex items-center justify-between flex-wrap bg-teal-500 p-6">
                        <div class="flex items-center flex-shrink-0 mr-6">
                            <svg class="h-8 w-8 text-red-600"  fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            
                            <NuxtLink :to="localePath('/')" :nuxt="true">
                                <span class="font-semibold text-xl tracking-tight ml-2">E-Com</span>
                            </NuxtLink>
                        </div>
                        <div class="block lg:hidden">
                            <button class="flex items-center px-3 py-2 border rounded text-teal-200 border-teal-400 hover:text-white hover:border-white">
                                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"/></svg>
                            </button>
                        </div>
                        <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
                            <div class="text-sm lg:flex-grow">
                                <NuxtLink :to="localePath('/')" :nuxt="true" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 mr-4">
                                    Home
                                </NuxtLink>
                                <NuxtLink v-if="!loggedIn" :to="localePath('user-auth-signin')" :nuxt="true" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 mr-4">
                                    Sign In
                                </NuxtLink>
                                <NuxtLink v-if="!loggedIn" :to="localePath('user-auth-signup')" :nuxt="true" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 mr-4">
                                    Sign Up
                                </NuxtLink>    
                                <NuxtLink v-if="loggedIn" :to="localePath('order-history')" :nuxt="true" class="block mt-4 lg:inline-block lg:mt-0 text-teal-200 mr-4">
                                    Order History
                                </NuxtLink>                             
                            </div>
                            <div v-if="loggedIn">
                                <a href="#" @click="logout" class="inline-block text-sm px-4 py-2 leading-none border rounded border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">Hi, {{ $auth.user.name }}</a>
                                <a href="#" @click="logout" class="inline-block text-sm px-4 py-2 leading-none border rounded border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">Sign Out</a>
                            </div>
                        </div>
                    </nav>
                    <nuxt />                    
                </div>                
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
export default {
    components: {

    },
    data: () => ({
        
    }),
    computed: {
        ...mapState("auth", ["loggedIn"]),
    },
    created() {
        
    },
    methods: {
        async logout() {
            this.$toast.show("Logging out...");
            await this.$auth.logout();
            this.$toast.clear();
            this.$toast.success("You have been logout due to inactivity!!");
        },
    }
};
</script>