import axios from "axios";
import {Promise} from "es6-promise";

const axiosInstance = axios.create({
    baseURL: import.meta.env.BASE_URL,
    withCredentials: true,
    withXSRFToken: true
});

axiosInstance.defaults.headers.common["Accept"] = "application/json";
// axiosInstance.defaults.headers.common["Referer"] = import.meta.env.BASE_URL;

axiosInstance.interceptors.response.use(
    response => response,
    error => {
        if (error.response.status === 401) {
            if (window.location.pathname !== "/login") {
                window.location.href = "/login";
            }
        }
        return Promise.reject(error);
    }
);

export default axiosInstance;
