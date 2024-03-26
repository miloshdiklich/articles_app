import axiosInstance from "../axiosInstance";
import { GET_ME_URL, LOGIN_URL, LOGOUT_URL } from "../../constants/enpoints";

export interface LoginData {
    email: string;
    password: string;
}

class AuthService {
    
    async getMe() {
        const res = await axiosInstance.get(`${GET_ME_URL}`);
        if (res) return res.data.data;
    }
    
    async postLogin(data: LoginData) {
        const res = await axiosInstance.post(`${LOGIN_URL}`, data);
        return res.data.data;
    }
    
    async postLogout() {
        const res = await axiosInstance.post(`${LOGOUT_URL}`);
        if (res) return res.data.data;
    }
}

export default new AuthService();
