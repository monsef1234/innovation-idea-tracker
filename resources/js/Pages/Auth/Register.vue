<template>
    <DefaultLayout>
        <div class="hero bg-base-200 min-h-screen">
            <div class="hero-content flex-col lg:flex-row-reverse">
                <div
                    class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl"
                >
                    <div class="card-body">
                        <fieldset class="fieldset">
                            <form
                                @submit.prevent="submit()"
                                class="flex flex-col gap-4"
                            >
                                <div>
                                    <label class="label">Name</label>
                                    <input
                                        type="text"
                                        class="input"
                                        placeholder="Name"
                                        v-model="form.name"
                                    />
                                    <small
                                        v-if="form.errors.name"
                                        class="text-red-500 mt-0.5 block"
                                    >
                                        {{ form.errors.name }}
                                    </small>
                                </div>
                                <div>
                                    <label class="label">Email</label>
                                    <input
                                        class="input"
                                        placeholder="Email"
                                        v-model="form.email"
                                    />
                                    <small
                                        v-if="form.errors.email"
                                        class="text-red-500 mt-0.5 block"
                                    >
                                        {{ form.errors.email }}
                                    </small>
                                </div>

                                <div>
                                    <label class="label">Role</label>
                                    <select class="select" v-model="form.role">
                                        <option selected value="submitter">
                                            Submitter
                                        </option>
                                        <option value="reviewer">
                                            Reviewer
                                        </option>
                                    </select>
                                </div>
                                <div>
                                    <label class="label">Password</label>
                                    <input
                                        type="password"
                                        class="input"
                                        placeholder="Password"
                                        v-model="form.password"
                                    />
                                    <small
                                        v-if="form.errors.password"
                                        class="text-red-500 mt-0.5 block"
                                    >
                                        {{ form.errors.password }}
                                    </small>
                                </div>
                                <div>
                                    <label class="label"
                                        >Confirm Password</label
                                    >
                                    <input
                                        type="password"
                                        class="input"
                                        placeholder="Confirm Password"
                                        v-model="form.password_confirmation"
                                    />
                                </div>
                                <!-- <div>
                                <a class="link link-hover">Forgot password?</a>
                            </div> -->
                                <button
                                    type="submit"
                                    class="btn btn-neutral mt-4"
                                    :disabled="form.processing"
                                >
                                    Register
                                </button>
                            </form>
                            <div>
                                <p>
                                    Already have an account?
                                    <Link
                                        href="/login"
                                        class="link text-blue-500"
                                        >Login</Link
                                    >
                                </p>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </DefaultLayout>
</template>

<script lang="ts">
import { defineComponent } from "vue";

import { useForm } from "@inertiajs/vue3";

export default defineComponent({
    name: "Register",

    data() {
        return {
            form: useForm({
                name: "",
                email: "",
                role: "submitter",
                password: "",
                password_confirmation: "",
            }),
        };
    },

    methods: {
        submit() {
            this.form.post("/register", {
                preserveScroll: true,
                onError: () => {
                    this.form.reset("password", "password_confirmation");
                },
            });
        },
    },
});
</script>
