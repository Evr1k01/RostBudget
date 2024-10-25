import axios from 'axios'

const token = sessionStorage.getItem('accessToken');

const instance = axios.create({
    baseURL: '/api/',
    timeout: -1
});

// установка токена для каждого axios запроса
instance.interceptors.request.use(function (config) {
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, function (error) {
    return Promise.reject(error);
});

export default instance
