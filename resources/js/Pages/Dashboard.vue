<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white p-10 overflow-hidden shadow-xl sm:rounded-lg"
                >
                    {{ msg }}
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
    components: {
        AppLayout
    },
    data() {
        return {
            msg: "Esperando resultado..."
        };
    },
    mounted() {
        Echo.channel("messages").listen(".message", e => {
            this.msg = e.msg;
        });
    }
};
</script>
