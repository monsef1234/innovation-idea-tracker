<template>
    <header>
        <div class="navbar bg-base-100 shadow-sm">
            <div class="flex-1">
                <Link href="/" class="btn btn-ghost text-xl"
                    >Innovation Idea Tracker</Link
                >
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal px-1">
                    <li v-if="$page?.props?.auth?.user?.role === 'admin'">
                        <Link href="/feedback">Feedback</Link>
                    </li>
                    <li
                        v-if="
                            !$page?.props?.auth?.user && $page.url !== '/login'
                        "
                    >
                        <Link href="/login">Login</Link>
                    </li>
                    <li
                        v-if="
                            !$page?.props?.auth?.user &&
                            $page.url !== '/register'
                        "
                    >
                        <Link href="/register">Register</Link>
                    </li>
                    <li v-if="$page?.props?.auth?.user">
                        <Link @click="logout">Logout</Link>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <main>
        <slot />
    </main>
</template>

<script lang="ts">
import { Link } from "@inertiajs/vue3";
import { defineComponent } from "vue";
import { router } from "@inertiajs/vue3";

export default defineComponent({
    name: "Default",

    components: {
        Link,
    },

    methods: {
        logout() {
            router.post("/logout");
        },
    },
});
</script>
