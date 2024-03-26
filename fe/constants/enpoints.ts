export const BASE_URL = `${import.meta.env.VITE_BASE_URL}`;
export const API_URL = `${BASE_URL}/api`;
export const GET_TOKEN = `${BASE_URL}/sanctum/csrf-cookie`;
export const LOGIN_URL = `${API_URL}/login`;
export const LOGOUT_URL = `${API_URL}/logout`;
export const GET_ME_URL = `${API_URL}/me`;
