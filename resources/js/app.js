import './bootstrap';
import '../css/app.css';
import Router from '@/router';

import { createApp } from 'vue/dist/vue.esm-bundler';
import { createPinia } from "pinia";

const pinia = createPinia();
const app = createApp({})
app.use(Router)
app.use(pinia)
app.mount('#app')
