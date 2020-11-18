<template>
    <AppLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Chat
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    class="bg-white overflow-hidden shadow sm:rounded-lg flex"
                    style="min-height: 600px; max-height: 600px;"
                >
                    <!-- list users -->
                    <div
                        class="w-3/12 bg-gray-200 bg-opacity-25 border-r border-gray-200 overflow-y-scroll"
                    >
                        <ul>
                            <li
                                @click.prevent="loadMessages(user.id)"
                                v-for="user in users"
                                :key="user.id"
                                :class="
                                    userActive.id == user.id
                                        ? 'bg-gray-200'
                                        : ''
                                "
                                class="p-6 text-lg text-gray-600 leading-7 font-semibold border-b border-gray-200 hover:bg-opacity-50 hover:cursor-pointer hover:bg-gray-200"
                            >
                                <p class="flex items-center">
                                    {{ user.name }}
                                    <span
                                        v-if="user.notification"
                                        class="ml-2 w-2 h-2 bg-blue-400 rounded-full"
                                    ></span>
                                </p>
                            </li>
                        </ul>
                    </div>

                    <!-- box msg -->
                    <div class="w-9/12 flex flex-col justify-between">
                        <!-- msg -->
                        <div class="w-full p-6 flex flex-col overflow-y-scroll">
                            <div
                                v-for="message in messages"
                                :key="message.id"
                                :class="
                                    message.from == $page.auth.user.id
                                        ? 'text-right'
                                        : ''
                                "
                                class="w-full mb-3 message"
                            >
                                <p
                                    :class="
                                        message.from == $page.auth.user.id
                                            ? 'messageFromMe'
                                            : 'messageToMe'
                                    "
                                    class="inline-block p-2 rounded-md max-w-2xl messageFromMe "
                                >
                                    {{ message.content }}
                                </p>
                                <span
                                    class="block mt-1 text-xs text-gray-500"
                                    >{{ message.created_at }}</span
                                >
                            </div>
                        </div>

                        <div
                            v-if="userActive.id"
                            class="w-full bg-gray-200 bg-opacity-25 p-6 border-t border-gray-200"
                        >
                            <form @submit.prevent="sendMessage">
                                <div
                                    class="flex rounded-md overflow-hidden border border-gray-300"
                                >
                                    <input
                                        v-model="message"
                                        type="text"
                                        class="flex-1 px-4 py-2 text-sm focus:outline-none "
                                    />
                                    <button
                                        class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2"
                                    >
                                        Enviar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import Vue from "vue";
import AppLayout from "@/Layouts/AppLayout";
import store from "../store";

export default {
    components: {
        AppLayout
    },
    data() {
        return {
            users: [],
            messages: [],
            userActive: {},
            message: ""
        };
    },
    methods: {
        scrollToBottom() {
            if (this.messages.length) {
                document
                    .querySelectorAll(".message:last-child")[0]
                    .scrollIntoView();
            }
        },
        loadMessages: async function(userId) {
            await axios
                .get(`api/users/${userId}`)
                .then(r => (this.userActive = r.data.user));

            await axios.get(`api/messages/${userId}`).then(r => {
                this.messages = r.data.messages;
            });

            const user = this.users.filter(user => {
                if (user.id === userId) {
                    return user;
                }
            });

            if (user) {
                Vue.set(user[0], "notification", false);
            }

            this.scrollToBottom();
        },
        sendMessage: async function() {
            if (this.message) {
                await axios
                    .post(`api/messages/store`, {
                        user_id: this.userActive.id,
                        message: this.message
                    })
                    .then(r => {
                        this.messages.push(r.data.message);
                        this.message = "";
                    });
                this.scrollToBottom();
            }
        }
    },
    computed: {
        user() {
            return store.state.user;
        }
    },
    mounted: async function() {
        await axios.get("/api/users").then(r => (this.users = r.data.users));

        Echo.private(`user.${this.user.id}`).listen(".SendMessage", async e => {
            if (this.userActive && this.userActive.id === e.message.from) {
                await this.messages.push(e.message);
                this.scrollToBottom();
            } else {
                const user = await this.users.filter(user => {
                    if (user.id === e.message.from) {
                        return user;
                    }
                });

                if (user) {
                    Vue.set(user[0], "notification", true);
                }
            }
        });
    }
};
</script>

<style>
.messageFromMe {
    @apply bg-blue-200;
}

.messageToMe {
    @apply bg-gray-100;
}
</style>
