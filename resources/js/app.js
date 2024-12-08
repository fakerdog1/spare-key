import '../css/app.css'
import './bootstrap';
import * as bootstrap from 'bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import registerPages from "@/vue/regjsterPages.js";
import Nora from '@primevue/themes/nora';
import Lara from '@primevue/themes/lara';      // Clean, modern design
import Aura from '@primevue/themes/aura';      // Soft, minimalist design

window.bootstrap = bootstrap;

const app = createApp({});

app.use(PrimeVue, {
  theme: {
    preset: Nora,
    options: {
      darkModeSelector: false
    }
  },
});

registerPages(app);

app.mount('#app');