import { ComponentCustomProperties } from "vue";
import { Page } from "@inertiajs/core";
import { PageProps } from "./inertia";

declare module "@vue/runtime-core" {
    interface ComponentCustomProperties {
        $page: Page<PageProps>;
    }
}
