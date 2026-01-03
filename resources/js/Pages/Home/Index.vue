<template>
    <DefaultLayout>
        <div class="max-w-5xl mx-auto p-4 space-y-4">
            <Add />
            <InfiniteScroll data="ideas">
                <div
                    v-for="idea in ideas.data"
                    :key="idea.id"
                    class="card bg-base-100 shadow-xl mb-4"
                >
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <h2 class="card-title">
                                {{ idea.title }}
                            </h2>

                            <span class="badge badge-primary">
                                {{ idea.category }}
                            </span>
                        </div>

                        <p class="text-gray-600">
                            {{ idea.description }}
                        </p>

                        <div class="text-sm text-gray-500">
                            Submitted by
                            <span class="font-medium">
                                {{ idea.user.name }}
                            </span>
                        </div>

                        <div
                            class="card-actions justify-between items-center mt-4"
                        >
                            <div class="flex items-center gap-2">
                                <button
                                    :disabled="
                                        $page?.props?.auth?.user?.role !==
                                            'admin' &&
                                        $page?.props?.auth?.user?.role !==
                                            'reviewer'
                                    "
                                    class="btn btn-sm"
                                    :class="
                                        isVotedUp(idea)
                                            ? 'btn-success'
                                            : 'btn-outline btn-success'
                                    "
                                    @click="vote(idea, 'up')"
                                >
                                    👍 Vote
                                </button>

                                <span class="font-bold text-lg">
                                    {{ idea.up_votes_count }}
                                </span>

                                <button
                                    class="btn btn-sm"
                                    :disabled="
                                        $page?.props?.auth?.user?.role !==
                                            'admin' &&
                                        $page?.props?.auth?.user?.role !==
                                            'reviewer'
                                    "
                                    :class="
                                        isVotedDown(idea)
                                            ? 'btn-error'
                                            : 'btn-outline btn-error'
                                    "
                                    @click="vote(idea, 'down')"
                                >
                                    👎
                                </button>
                            </div>

                            <button
                                class="btn btn-sm btn-outline"
                                @click="openCommentsModal(idea)"
                            >
                                💬 Comments
                                <span
                                    v-if="
                                        idea.comments &&
                                        idea.comments.length > 0
                                    "
                                    class="badge badge-sm"
                                >
                                    {{ idea.comments.length }}
                                </span>
                            </button>
                        </div>
                        <div class="flex justify-end gap-2 mt-2">
                            <button
                                v-if="$page.props.auth.user?.role === 'admin'"
                                class="btn btn-sm btn-error btn-outline"
                                @click="deleteIdea(idea)"
                            >
                                Delete Idea
                            </button>
                        </div>
                    </div>
                </div>
            </InfiniteScroll>
        </div>

        <!-- Comments Modal Component -->
        <Comments
            v-if="selectedIdea"
            :idea="selectedIdea"
            @close="closeCommentsModal"
        />

        <div class="toast toast-end z-50">
            <div class="alert alert-error" v-if="$page.props.flash.error">
                <span>{{ $page.props.flash.error }}</span>
            </div>
            <div class="alert alert-success" v-if="$page.props.flash.success">
                <span>{{ $page.props.flash.success }}</span>
            </div>
        </div>

        <div
            class="fixed bottom-4 right-4 cursor-pointer hover:scale-110 transition-all p-2 bg-white rounded-full"
            @click="openModal"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                color="black"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-chat-left-text-fill"
                viewBox="0 0 16 16"
            >
                <path
                    d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H4.414a1 1 0 0 0-.707.293L.854 15.146A.5.5 0 0 1 0 14.793zm3.5 1a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 2.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z"
                />
            </svg>
        </div>

        <AddFeedback />
    </DefaultLayout>
</template>

<script lang="ts">
import { defineComponent } from "vue";

import DefaultLayout from "@/Layouts/Default.vue";
import { router, InfiniteScroll } from "@inertiajs/vue3";
import Add from "./dialogs/Add.vue";
import AddFeedback from "./dialogs/AddFeedback.vue";
import Comments from "./dialogs/Comments.vue";

interface User {
    id: number;
    name: string;
}

interface Vote {
    id: number;
    vote_type: string;
    idea_id: number;
    user_id: number;
}

interface Comment {
    id: number;
    body: string;
    user: User;
    created_at: string;
}

interface Idea {
    id: number;
    title: string;
    description: string;
    category: string;
    user: User;
    votes: Vote[];
    comments?: Comment[];
}

export default defineComponent({
    name: "Home",

    components: {
        DefaultLayout,
        InfiniteScroll,
        Add,
        Comments,
        AddFeedback,
    },

    props: {
        auth: {
            type: Object,
            required: true,
        },

        ideas: {
            type: Object as any,
            required: true,
        },
    },

    data() {
        return {
            selectedIdea: null as Idea | null,
        };
    },

    watch: {
        "$page.props.flash": {
            handler() {
                setTimeout(() => {
                    this.$page.props.flash = {};
                }, 8000);
            },
            deep: true,
        },

        "ideas.data": {
            handler() {
                if (this.selectedIdea) {
                    this.selectedIdea.comments = this.ideas.data.find(
                        (idea: Idea) => idea.id === this.selectedIdea.id
                    )?.comments;
                }
            },
            deep: true,
        },
    },

    methods: {
        isVotedUp(idea: Idea) {
            return idea.votes.some(
                (vote) =>
                    vote.user_id === this.$page.props.auth.user?.id &&
                    vote.vote_type === "up"
            );
        },

        isVotedDown(idea: Idea) {
            return idea.votes.some(
                (vote) =>
                    vote.user_id === this.$page.props.auth.user?.id &&
                    vote.vote_type === "down"
            );
        },

        openModal() {
            (document.getElementById("my_modal_3") as any)?.showModal();
        },

        vote(idea: Idea, type: "up" | "down") {
            router.post(
                `/ideas/${idea.id}/vote`,
                {
                    vote_type: type,
                },
                {
                    preserveScroll: true,
                }
            );
        },

        openCommentsModal(idea: Idea) {
            this.selectedIdea = idea;
        },

        closeCommentsModal() {
            this.selectedIdea = null;
        },

        deleteIdea(idea: Idea) {
            router.delete(`/ideas/${idea.id}`, {
                preserveScroll: true,
            });
        },
    },
});
</script>
