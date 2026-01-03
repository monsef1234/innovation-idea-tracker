<template>
    <DefaultLayout>
        <div class="max-w-3xl mx-auto p-4 space-y-4">
            <h1 class="text-2xl font-bold mb-4">Feedbacks</h1>

            <div v-if="feedbacks.length">
                <div
                    v-for="feedback in feedbacks"
                    :key="feedback.id"
                    class="card bg-base-100 shadow-md p-4 border border-gray-200 hover:border-gray-400 mb-4 rounded-lg"
                >
                    <div class="flex justify-between items-start mb-2">
                        <div class="font-semibold">
                            {{ feedback.user.name }}
                        </div>
                        <div class="text-xs">
                            {{ formatDate(feedback.created_at) }}
                        </div>
                    </div>
                    <p class="text-gray-700">{{ feedback.body }}</p>
                </div>
            </div>

            <div v-else class="text-center text-gray-500 py-8">
                No feedback yet. Be the first to add one!
            </div>
        </div>
    </DefaultLayout>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import DefaultLayout from "@/Layouts/Default.vue";

interface User {
    id: number;
    name: string;
    role: string;
}

interface Feedback {
    id: number;
    body: string;
    user: User;
    created_at: string;
}

export default defineComponent({
    name: "Feedback",

    components: { DefaultLayout },

    props: {
        feedbacks: {
            type: Array as PropType<Feedback[]>,
            required: true,
        },
    },

    methods: {
        formatDate(dateString: string) {
            const date = new Date(dateString);
            return date.toLocaleString([], {
                year: "numeric",
                month: "short",
                day: "numeric",
                hour: "2-digit",
                minute: "2-digit",
            });
        },
    },
});
</script>
