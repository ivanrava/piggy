/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import {useAuth} from "./composables/useAuth";

axios.defaults.baseURL = `${import.meta.env.VITE_API_BASE_URL}/api`;
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Content-Type'] = 'application/json';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.withCredentials = true;
axios.interceptors.response.use(
    // Do nothing, we only care about the failures
    (res) => res,
    // If 401 / 419, session is expired. Go to SPA /login.
    // In any other case, pass the error with a rejected promise.
    // The /user exception is provided for the route guard.
    (error) => {
        if ([401, 419].includes(error.response.status) && !error.request.responseURL.endsWith('/api/user')) {
            const {logout} = useAuth();
            logout();
        } else {
            return Promise.reject(error)
        }
    },
)

await axios.get("/sanctum/csrf-cookie", {
    baseURL: import.meta.env.VITE_API_BASE_URL
});
