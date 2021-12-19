<template>
    <div class="container">
        <!--Nav-->
        <nav class="bg-gray-800 pt-2 md:pt-1 pb-1 px-1 mt-0 h-auto fixed w-full z-20 top-0">
            <div class="flex flex-wrap items-center">
                <div class="flex flex-shrink md:w-1/3 justify-center md:justify-start text-white">
                    <a href="#">
                        <span class="text-xl pl-2"><i class="em em-grinning"></i></span>
                    </a>
                </div>

                <div class="flex flex-1 md:w-1/3 justify-center md:justify-start text-white px-2">
                    <span class="relative w-full">
                        <input type="search" placeholder="Search" class="w-full bg-gray-900 text-white transition border border-transparent focus:outline-none focus:border-gray-400 rounded py-3 px-2 pl-10 appearance-none leading-normal">
                        <div class="absolute search-icon" style="top: 1rem; left: .8rem;">
                            <svg class="fill-current pointer-events-none text-white w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z"></path>
                            </svg>
                        </div>
                    </span>
                </div>

                <div v-if="loggedIn" class="flex w-full pt-2 content-center justify-between md:w-1/3 md:justify-end">
                    <ul class="list-reset flex justify-between flex-1 md:flex-none items-center">                        
                        <li class="flex-1 md:flex-none md:mr-3">
                            <div class="relative inline-block">
                                <button class="drop-button text-white focus:outline-none"> <span class="pr-2"><i class="em em-robot_face"></i></span> Hi, {{ $auth.user.name }} </button>
                            </div>
                        </li>
                        <li class="flex-1 md:flex-none md:mr-3">
                            <a class="inline-block py-2 px-4 text-white no-underline" href="#" @click="logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="flex flex-col md:flex-row">
            <div class="bg-gray-800 shadow-xl h-16 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-48">
                <div class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
                    <ul class="list-reset flex flex-row md:flex-col py-0 md:py-3 px-1 md:px-2 text-center md:text-left">
                        <li v-for="(item, i) in menuItems" :key="i" class="mr-3 flex-1">
                            <NuxtLink :to="localePath(item.route)" :nuxt="true" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500">
                                <span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">
                                    {{ item.title }}
                                </span>
                            </NuxtLink>                            
                        </li>                        
                    </ul>
                </div>
            </div>

            <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-12 pb-24 md:pb-5">
                <nuxt />
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import menu from "@/data/menu";
export default {
    components: {

    },
    data: () => ({
        idelCount: true,
    }),
    computed: {
        ...mapState("auth", ["loggedIn"]),
        breadcrumbs: function () {
            let breadcrumbs = [];
            breadcrumbs = this.loopThroughMenuItems(menu);
            return breadcrumbs;
        },
        drawer: {
			get() {
				return this.$store.state.drawer;
			},
			set(val) {
				this.$store.commit("drawer", val);
			},
		},
        menuItems() {
			const items = [];
			menu.forEach((item) => {
				let addIt = true;
				if (item.hasOwnProperty("forRoles")) {
					addIt = false;
					for (let i = 0; i < this.user.roles.length; i++) {
						const role = this.user.roles[i];
						if (item.forRoles.indexOf(role) > -1) {
							addIt = true;
							break;
						}
					}
				}
				if (addIt) {
					items.push(item);
				}
			});
			return items;
		},
    },
    created() {
        this.$nuxt.$on('disableIdleCount', () => {
            this.idelCount = false
        })
        this.$nuxt.$on('enableIdelCount', () => {
            this.idelCount = true
        }) 
    },
    mounted() {
		if(this.$auth.user && this.$auth.user.role == 'user') {
            this.$router.push(this.localePath("/"));
        }
	},
    beforeDestroy(){
        this.$nuxt.$off('disableIdleCount', () => {
            this.idelCount = false
        });
        this.$nuxt.$off('enableIdelCount', () => {
            this.idelCount = true
        });
    },
    methods: {
        async logout() {
            this.$toast.show("Logging out...");
            await this.$auth.logout();
            this.$toast.clear();
            this.$toast.success("You have been logout due to inactivity!!");
        },
        loopThroughMenuItems(items){
            let breadcrumbs = [];
            items.forEach((item) => {
                if (item.items) {
                    let child = item.items.find((i) => {
                        return i.route === this.getRouteBaseName();
                    });
                    if (child) {
                        breadcrumbs.push({ text: item.title });
                        breadcrumbs.push(...this.loopThroughMenuItems(item.items));
                    }else{
                        breadcrumbs.push(...this.loopThroughMenuItems(item.items));
                    }
                } else {
                    if (item.route === this.getRouteBaseName()) {
                        breadcrumbs.push({ text: item.title, disabled: true });
                    }
                }
            });
            return breadcrumbs;
        },
    }
};
</script>