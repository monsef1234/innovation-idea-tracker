<template>
    <div class="space-y-3">
        <div
            :class="[
                'relative mb-2',
                depth > 0 ? 'ml-8 pl-4 border-l-2 border-base-300' : '',
            ]"
        >
            <div
                class="bg-base-200 p-4 rounded-lg hover:bg-base-300 transition-colors"
            >
                <div class="flex items-start justify-between mb-2">
                    <div class="font-semibold text-sm">
                        {{ comment.user.name }}
                    </div>
                    <div class="text-xs text-gray-500">
                        {{ formatDate(comment.created_at) }}
                    </div>
                </div>
                <p class="text-sm mb-3 whitespace-pre-wrap">
                    {{ comment.body }}
                </p>
                <button
                    v-if="!maxDepthReached"
                    class="btn btn-xs btn-ghost text-primary gap-1"
                    @click="handleReply"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-3 w-3"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"
                        />
                    </svg>
                    Reply
                </button>
            </div>

            <div v-if="hasReplies" class="my-3 space-y-3">
                <CommentThread
                    v-for="reply in replies"
                    :key="reply.id"
                    :comment="reply"
                    :all-comments="allComments"
                    :depth="depth + 1"
                    @reply="$emit('reply', $event)"
                />
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";

interface User {
    id: number;
    name: string;
}

interface Comment {
    id: number;
    body: string;
    user: User;
    created_at: string;
    parent_id?: number | null;
}

export default defineComponent({
    name: "CommentThread",

    props: {
        comment: {
            type: Object as PropType<Comment>,
            required: true,
        },

        allComments: {
            type: Array as PropType<Comment[]>,
            required: true,
        },

        depth: {
            type: Number,
            default: 0,
        },
    },

    emits: ["reply"],

    computed: {
        replies(): Comment[] {
            return this.allComments.filter(
                (c) => c.parent_id === this.comment.id
            );
        },

        hasReplies(): boolean {
            return this.replies.length > 0;
        },

        maxDepthReached(): boolean {
            return this.depth >= 3;
        },
    },

    methods: {
        formatDate(dateString: string) {
            const date = new Date(dateString);
            const now = new Date();
            const diffMs = now.getTime() - date.getTime();
            const diffMins = Math.floor(diffMs / 60000);
            const diffHours = Math.floor(diffMs / 3600000);
            const diffDays = Math.floor(diffMs / 86400000);

            if (diffMins < 1) return "Just now";
            if (diffMins < 60) return `${diffMins}m ago`;
            if (diffHours < 24) return `${diffHours}h ago`;
            if (diffDays < 7) return `${diffDays}d ago`;

            return date.toLocaleDateString();
        },

        handleReply() {
            this.$emit("reply", this.comment);
        },
    },
});
</script>
