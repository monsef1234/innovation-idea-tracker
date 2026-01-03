<template>
    <div class="hero bg-base-200 min-h-screen">
        <div class="hero-content flex-col lg:flex-row-reverse">
            <div class="card bg-base-100 w-full max-w-sm shrink-0 shadow-2xl">
                <div class="card-body">
                    <fieldset class="fieldset">
                        <form
                            @submit.prevent="submit()"
                            class="flex flex-col gap-4"
                        >
                            <div>
                                <label class="label" for="email">Email</label>
                                <input
                                    class="input"
                                    id="email"
                                    placeholder="Email"
                                    v-model="form.email"
                                />
                                <span
                                    v-if="form.errors.email"
                                    class="text-red-500"
                                >
                                    {{ form.errors.email }}
                                </span>
                            </div>
                            <div>
                                <label class="label" for="password"
                                    >Password</label
                                >
                                <input
                                    type="password"
                                    class="input"
                                    placeholder="Password"
                                    id="password"
                                    v-model="form.password"
                                />

                                <span
                                    v-if="form.errors.password"
                                    class="text-red-500"
                                >
                                    {{ form.errors.password }}
                                </span>
                            </div>
                            <div>
                                <label for="remember" class="label">
                                    <input
                                        type="checkbox"
                                        id="remember"
                                        v-model="form.remember"
                                    />

                                    Remember me
                                </label>
                            </div>

                            <button
                                type="submit"
                                class="btn btn-neutral mt-4"
                                :disabled="form.processing"
                            >
                                Login
                            </button>
                        </form>
                        <div>
                            <p>
                                Don't have an account?
                                <Link
                                    href="/register"
                                    class="link text-blue-500"
                                    >Register</Link
                                >
                            </p>
                        </div>

                        <div class="mt-4 text-center">
                            <Link href="/" class="link">
                                Continue as a guest
                            </Link>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

import { useForm } from "@inertiajs/vue3";

export default defineComponent({
    name: "Login",

    data() {
        return {
            form: useForm({
                email: "",
                password: "",
                remember: false,
            }),
        };
    },

    methods: {
        submit() {
            this.form.post("/login");
        },
    },
});
</script>
