<template>
    <dialog ref="modal" class="modal" @close="handleClose">
        <div class="modal-box max-w-4xl max-h-[90vh]">
            <form method="dialog">
                <button
                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2"
                >
                    ✕
                </button>
            </form>

            <h3 class="font-bold text-lg mb-4">
                Comments for: {{ idea.title }}
            </h3>

            <div class="space-y-4 mb-6 max-h-[50vh] overflow-y-auto pr-2">
                <div v-if="idea.comments && idea.comments.length > 0">
                    <CommentThread
                        v-for="comment in topLevelComments"
                        :key="comment.id"
                        :comment="comment"
                        :all-comments="idea.comments"
                        @reply="handleReply"
                    />
                </div>

                <div v-else class="text-center text-gray-500 py-8">
                    No comments yet. Be the first to comment!
                </div>
            </div>

            <!-- Add Comment Form -->
            <div class="form-control pt-4">
                <div
                    v-if="replyTo"
                    class="mb-2 p-2 bg-base-200 rounded flex items-center justify-between"
                >
                    <span class="text-sm">
                        Replying to
                        <span class="font-semibold">{{
                            replyTo.user.name
                        }}</span>
                    </span>
                    <button class="btn btn-xs btn-ghost" @click="cancelReply">
                        ✕
                    </button>
                </div>
                <input
                    v-model="newComment"
                    class="input input-bordered w-full"
                    :placeholder="
                        replyTo ? 'Write a reply...' : 'Share your thoughts...'
                    "
                    @keydown.enter="submitComment"
                />
                <div class="mt-4 flex justify-end gap-2">
                    <button class="btn btn-ghost" @click="close">Close</button>
                    <button
                        class="btn btn-primary"
                        @click="submitComment"
                        :disabled="!newComment.trim()"
                    >
                        {{ replyTo ? "Post Reply" : "Post Comment" }}
                    </button>
                </div>
            </div>
        </div>
    </dialog>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import { router } from "@inertiajs/vue3";
import CommentThread from "./CommentThread.vue";

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

interface Idea {
    id: number;
    title: string;
    description: string;
    category: string;
    user: User;
    comments?: Comment[];
}

export default defineComponent({
    name: "Comments",

    components: {
        CommentThread,
    },

    props: {
        idea: {
            type: Object as PropType<Idea>,
            required: true,
        },
    },

    emits: ["close"],

    data() {
        return {
            newComment: "",
            replyTo: null as Comment | null,
        };
    },

    computed: {
        topLevelComments(): Comment[] {
            if (!this.idea.comments) return [];
            return this.idea.comments.filter(
                (comment) => !comment.parent_id || comment.parent_id === null
            );
        },
    },

    watch: {
        idea: {
            handler() {
                console.log(this.idea);
            },
            deep: true,
        },
    },

    mounted() {
        (this.$refs.modal as HTMLDialogElement).showModal();
    },

    methods: {
        close() {
            (this.$refs.modal as HTMLDialogElement).close();
        },

        handleClose() {
            this.$emit("close");
        },

        handleReply(comment: Comment) {
            this.replyTo = comment;
            this.newComment = "";
        },

        cancelReply() {
            this.replyTo = null;
            this.newComment = "";
        },

        submitComment() {
            if (!this.newComment.trim()) return;

            router.post(
                `/ideas/${this.idea.id}/comments`,
                {
                    body: this.newComment,
                    parent_id: this.replyTo?.id || null,
                },
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.newComment = "";
                        this.replyTo = null;
                    },
                }
            );
        },
    },
});
</script>
