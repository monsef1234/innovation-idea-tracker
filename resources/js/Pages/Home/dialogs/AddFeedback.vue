<template>
    <dialog id="my_modal_3" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold text-center mb-4">Add Feedback</h3>
            <form @submit.prevent="addFeedback" class="flex flex-col gap-4">
                <div>
                    <textarea
                        class="textarea w-full"
                        rows="4"
                        maxlength="255"
                        v-model="form.body"
                        placeholder="Write your feedback here..."
                    ></textarea>

                    <small class="text-red-500" v-if="form.errors.body">
                        {{ form.errors.body }}
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

    data() {
        return {
            form: useForm({
                body: "",
            }),
        };
    },

    methods: {
        addFeedback() {
            this.form.post("/feedback", {
                preserveScroll: true,
                onSuccess: () => {
                    (document.getElementById("my_modal_3") as any)?.close();
                    this.form.reset();
                },
            });
        },
    },
});
</script>
