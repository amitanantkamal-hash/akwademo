
import "./bootstrap";
import "./config";
import "./alpine-init";
import "@nextapps-be/livewire-sortablejs";

import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.css";
import "./tippy";
import GLightbox from "glightbox";
// Import theme utilities
import { refreshThemeStyle } from "./theme/refreshTheme";
// Vue Import
import { createApp } from "vue";
import BotFlowBuilder from "./components/BotFlowBuilder.vue";

// Import Vue Select
import vSelect from "vue3-select";
import "vue3-select/dist/vue3-select.css";

// Create Vue app for specific components
document.addEventListener("DOMContentLoaded", function () {

    const el = document.getElementById("bot-flow-builder");

    if (el) {
        const app = createApp({});
        app.component("v-select", vSelect);
        app.component("bot-flow-builder", BotFlowBuilder);
        app.mount(el);
    }

    refreshThemeStyle();
});


// Store the lightbox instance globally
window.GLightboxInstance = null;

// Define a global function to initialize GLightbox
window.initGLightbox = function () {
    // Destroy previous instance if it exists
    if (window.GLightboxInstance) {
        window.GLightboxInstance.destroy();
    }

    // Create new instance
    window.GLightboxInstance = GLightbox({
        selector: ".glightbox",
        touchNavigation: true,
        loop: true,
        zoomable: true,
        autoplayVideos: true,
    });
};

// Initialize once on DOM ready
document.addEventListener("DOMContentLoaded", function () {
    window.initGLightbox();
});
