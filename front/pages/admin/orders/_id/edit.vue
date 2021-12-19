<template>
    <div>
        <div class="bg-gray-800 pt-3">
            <div class="rounded-tl-3xl bg-gradient-to-r from-blue-900 to-gray-800 p-4 shadow text-2xl text-white">
                <h3 class="font-bold pl-2"><span>Order Details</span></h3>
            </div>
        </div>

        <div class="flex flex-wrap">
            <edit-form operation="edit"/>
        </div>
    </div>
</template>

<script>
import EditForm from '@/components/order/CreateEditForm';
export default {
    components: {
        EditForm
    },
    data() {
        return {
            
        }
    },
    methods: {
        
    },
}
</script>