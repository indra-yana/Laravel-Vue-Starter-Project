import axios from 'axios';
import router from '.././router';
import { authState } from '.././store/authState.js';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.withCredentials = true;
axios.interceptors.response.use(undefined, function (error) {
    if (error) {
        const originalRequest = error.config;
        if (error.response.status === 401 && !originalRequest._retry) {
            originalRequest._retry = true;
            const store = authState();
            store.logout();
            
            return router.push({name: 'login'});
        }
    }
});

export default axios;