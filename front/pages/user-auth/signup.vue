<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg">
            <h3 class="text-2xl font-bold text-center">Create your account to signin</h3>
            <form action="" @submit.prevent="registraion">
                <div class="mt-4">
                    <div>
                        <label class="block" for="name">Name</label>
                        <input v-model="form.name" type="text" placeholder="Name" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                        <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                            {{$getValidationError(errors, 'name')}}
                        </span>
                    </div>
                    <div>
                        <label class="block" for="email">Email</label>
                        <input v-model="form.email" type="text" placeholder="Email" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                        <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                            {{$getValidationError(errors, 'email')}}
                        </span>
                    </div>
                    <div class="mt-4">
                        <label class="block">Password</label>
                        <input v-model="form.password" type="password" placeholder="Password" class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600">
                        <span class="flex items-center font-medium tracking-wide text-red-500 text-xs mt-1 ml-1">
                            {{$getValidationError(errors, 'password')}}
                        </span>
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
    layout: "front",
    auth: "guest",
    data() {
        return {
            loading: false,
            form: {
                name : "",
                email: "",
                password: "",
                role : 'user'
            },
            errors: null,
        };
    },
    methods: {
        async registraion() {
            try {
                let response = await this.$axios.$post("v1/auth/registraion", this.form);
                if (response.success) {
                    this.$router.push(this.localePath("user-auth-signin"));                   
                    this.$toast.clear();
                    this.$toast.success("Account created successfully");
                } else {
                    this.$toast.clear();
                    this.$toast.error("Operation Failed");
                }
            } catch (error) {
                this.errors = error.response.data.errors;
                this.$toast.clear();
                this.$toast.error("Operation Failed");
                setTimeout(() => {
                    this.$scrollTo(".error--text", {
                        offset: -100,
                    });
                }, 500);
            }
        },
    },
};
</script>