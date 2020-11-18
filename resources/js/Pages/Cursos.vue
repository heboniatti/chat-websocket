<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cursos
            </h2>
        </template>

        <div class="md:py-12 py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white md:overflow-hidden p-5 overflow-x-auto  shadow-xl sm:rounded-lg"
                >
                    <table class="table-fixed">
                        <thead>
                            <tr>
                                <th class="w-1/2 px-4 py-2">Title</th>
                                <th class="w-1/4 px-4 py-2">Author</th>
                                <th class="w-1/4 px-4 py-2">Views</th>
                                <th class="w-1/4 px-4 py-2">Views</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="border px-4 py-2">Intro to CSS</td>
                                <td class="border px-4 py-2">Adam</td>
                                <td class="border px-4 py-2">858</td>
                                <td class="border px-4 py-2">858</td>
                            </tr>
                            <tr class="bg-gray-100">
                                <td class="border px-4 py-2">
                                    A Long and Winding Tour of the History of UI
                                    Frameworks and Tools and the Impact on
                                    Design
                                </td>
                                <td class="border px-4 py-2">Adam</td>
                                <td class="border px-4 py-2">112</td>
                                <td class="border px-4 py-2">112</td>
                            </tr>
                            <tr>
                                <td class="border px-4 py-2">
                                    Intro to JavaScript
                                </td>
                                <td class="border px-4 py-2">Chris</td>
                                <td class="border px-4 py-2">1,280</td>
                                <td class="border px-4 py-2">1,280</td>
                            </tr>
                        </tbody>
                    </table>
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
    }
};
</script>

<style lang="scss" scoped></style>
