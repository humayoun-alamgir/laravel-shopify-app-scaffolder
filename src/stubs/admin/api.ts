import axios, { AxiosInstance } from 'axios';
import config from '@admin/config';
import { getSessionToken } from '@shopify/app-bridge-utils';
import { app } from '@/admin/installer';

const apiInstance: AxiosInstance = axios.create({
    baseURL: config.api.url
});

apiInstance.interceptors.request.use(function(config) {
    return getSessionToken(app).then((token) => {
        config.headers['Authorization'] = `Bearer ${token}`;
        return config;
    });
}, function(error) {
    return Promise.reject(error);
});

export class ApiClient {

    http: AxiosInstance = apiInstance;

    // Add your api functions here :)
}

export const api = new ApiClient();
