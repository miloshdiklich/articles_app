import { useMutation, useQuery } from "@tanstack/react-query";
import authService, { LoginData } from "../services/auth/authService";
import { useNavigate } from "react-router-dom";

export type TApiResponse = {
    response: {
        data: {
            message: string;
            status: string;
            status_code: number;
            data: object
        }
    }
}

export const useAuth = () => {
    
    const navigate = useNavigate();
    
    const getMe = useQuery({
        queryKey: ["me"],
        queryFn: () => authService.getMe(),
        retry: 0,
        refetchOnWindowFocus: false
    })
    
    const login = useMutation<LoginData, TApiResponse, LoginData>({
        mutationFn: (data: LoginData) => authService.postLogin(data),
        onSuccess: () => {
            navigate("/dashboard");
        },
    });
    
    const logout = useMutation({
        mutationFn: () => authService.postLogout(),
        onSuccess: () => {
            navigate("/login");
        }
    });
    
    return {
        getMe,
        login,
        logout
    }
};
