<template>
    <div>
        <div class="bg-gray-800 pt-3">
            <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
                <h3 class="font-bold pl-2"><span>Create new Product</span></h3>
            </div>
        </div>

        <div class="flex flex-wrap">
            <create-form operation="create"/>
        </div>
    </div>
</template>

<script>
import CreateForm from '@/components/product/CreateEditForm';
export default {
    components: {
        CreateForm
    },
    data() {
        return {
            
        }
    },
    methods: {
        
    },
}
</script>