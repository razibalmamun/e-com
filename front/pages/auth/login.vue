<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg">
            <h3 class="text-2xl font-bold text-center">Login to your account</h3>
            <form action="" @submit.prevent="login">
                <div class="mt-4">
                    <div>
                        <label class="block" for="email">Email</label>
                        <input v-model="form.email" type="text" placeholder="Email" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                    </div>
                    <div class="mt-4">
                        <label class="block">Password</label>
                        <input v-model="form.password" type="password" placeholder="Password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                    </div>
                    <div class="flex items-baseline justify-between">
                        <button class="px-6 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-900">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    layout: "auth",
    auth: "guest",
    data() {
        return {
            loading: false,
            form: {
                email: "",
                password: "",
                role : 'admin',
            },
            errors: null,
        };
    },
    methods: {
        async login() {
            this.errors = null;
            this.loading = true;
            try {
                await this.$auth.loginWith("local", { data: this.form });
                this.$toast.clear();
                this.$toast.success("Logged in Successfully...");
                this.loading = false;
            } catch (error) {
                this.errors = error.response
                    ? error.response.data.errors
                    : null;
                this.$toast.clear();
                this.$toast.error("Login Failed");
                this.loading = false;
            }
        },
    },
};
</script>