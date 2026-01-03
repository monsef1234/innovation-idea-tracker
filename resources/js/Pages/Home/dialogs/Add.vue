<template>
    <button class="btn" @click="openModal()">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            fill="currentColor"
            class="bi bi-plus"
            viewBox="0 0 16 16"
        >
            <path
                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"
            />
        </svg>
        Add an idea
    </button>
    <dialog id="my_modal_2" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold text-center mb-4">Add an idea</h3>
            <form @submit.prevent="addIdea" class="flex flex-col gap-4">
                <div>
                    <input
                        class="input w-full"
                        v-model="form.title"
                        type="text"
                        placeholder="Title"
                    />
                    <small class="text-red-500" v-if="form.errors.title">
                        {{ form.errors.title }}
                    </small>
                </div>
                <div>
                    <textarea
                        class="textarea w-full"
                        v-model="form.description"
                        rows="4"
                        maxlength="255"
                        placeholder="Description"
                    ></textarea>
                    <small class="text-red-500" v-if="form.errors.description">
                        {{ form.errors.description }}
                    </small>
                </div>
                <div>
                    <input
                        class="input w-full"
                        v-model="form.category"
                        type="text"
                        placeholder="Category"
                    />
                    <small class="text-red-500" v-if="form.errors.category">
                        {{ form.errors.category }}
                    </small>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import { useForm } from "@inertiajs/vue3";

export default defineComponent({
    name: "Add",

    emits: ["idea-added"],

    data() {
        return {
            form: useForm({
                title: "",
                description: "",
                category: "",
            }),
        };
    },

    methods: {
        openModal() {
            (document.getElementById("my_modal_2") as any)?.showModal();
        },

        addIdea() {
            this.form.post("/ideas", {
                preserveScroll: true,
                onSuccess: (data: any) => {
                    (document.getElementById("my_modal_2") as any)?.close();
                    this.form.reset();
                },
            });
        },
    },
});
</script>
