import './bootstrap';
import '../css/app.css';
import Router from '@/router';

import { createApp } from 'vue/dist/vue.esm-bundler';

const app = createApp({})
app.use(Router)
app.mount('#app')
