/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';

axios.defaults.baseURL = `${import.meta.env.VITE_API_BASE_URL}/api`;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.withCredentials = true;

await axios.get("/sanctum/csrf-cookie", {
    baseURL: import.meta.env.VITE_API_BASE_URL
});
