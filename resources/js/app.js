import '../css/app.css'
import './bootstrap';
import * as bootstrap from 'bootstrap';
import { createApp } from 'vue';
import PrimeVue from 'primevue/config';
import registerPages from "@/vue/regjsterPages.js";
import Nora from '@primevue/themes/nora';

window.bootstrap = bootstrap;

const app = createApp({});

app.use(PrimeVue, {
  theme: {
    preset: Nora
  }
});

registerPages(app);

app.mount('#app');