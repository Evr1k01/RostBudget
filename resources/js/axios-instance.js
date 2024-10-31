import axios from 'axios'

const axios$ = axios.create({
    baseURL: '/api/',
    timeout: -1
});

axios$.interceptors.request.use(function (config)
{
    const token = localStorage.getItem('accessToken');

    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, function (error) {
    return Promise.reject(error);
});

export default axios$
