import React from "react";
import { useForm } from "react-hook-form";
import { userSchema } from "../../schemas/userSchema.ts";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { useAuth } from "../../hooks/useAuth.ts";
import { LoginData } from "../../services/auth/authService.ts";

export interface LoginProps {
    email: string;
    password: string;
}

export type TUserLogin = z.infer<typeof userSchema>;

const Login: React.FC = () => {
    
    const {login} = useAuth();
    
    const {
        register,
        handleSubmit,
        reset,
        formState: { errors },
    } = useForm<TUserLogin>({
        resolver: zodResolver(userSchema),
    });
    
    const labelError = (errors && "text-destructive5") || "";
    
    const handleLogin = (data: LoginData) => {
        login.mutate(data);
    }
    
    return (
        <>
            <h2>Vite is running in {import.meta.env.VITE_ENV}</h2>
            <div className="flex items-center min-h-screen p-4 bg-gray-100 lg:justify-center">
                <div
                    className="flex flex-col overflow-hidden bg-white rounded-md shadow-lg max md:flex-row md:flex-1 lg:max-w-screen-md"
                >
                    <div className="p-5 bg-white md:flex-1">
                        <h3 className="my-4 text-2xl font-semibold text-gray-700">Account Login</h3>
                        <form
                            className="flex flex-col space-y-5"
                            onSubmit={handleSubmit(data => {
                                handleLogin(data);
                                reset();
                            })}
                        >
                            <div className="flex flex-col space-y-1">
                                <label className={`text-sm font-semibold text-gray-500 ${labelError}`}>Email address</label>
                                <input
                                    type="email"
                                    id="email"
                                    className="px-4 py-2 transition duration-300 border border-gray-300 rounded focus:border-transparent focus:outline-none focus:ring-4 focus:ring-blue-200"
                                    {...register("email")}
                                />
                            </div>
                            <div className="flex flex-col space-y-1">
                                <div className="flex items-center justify-between">
                                    <label className="text-sm font-semibold text-gray-500">Password</label>
                                    {/*<a href="#" className="text-sm text-blue-600 hover:underline focus:text-blue-800">Forgot*/}
                                    {/*    Password?</a>*/}
                                </div>
                                <input
                                    type="password"
                                    id="password"
                                    className="px-4 py-2 transition duration-300 border border-gray-300 rounded focus:border-transparent focus:outline-none focus:ring-4 focus:ring-blue-200"
                                    {...register("password")}
                                />
                            </div>
                            <div className="flex items-center space-x-2">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    className="w-4 h-4 transition duration-300 rounded focus:ring-2 focus:ring-offset-0 focus:outline-none focus:ring-blue-200"
                                />
                                <label className="text-sm font-semibold text-gray-500">Remember me</label>
                            </div>
                            {login.error && (
                                <div className="w-full">
                                    {login.error.response.data.message}
                                </div>
                            )}
                            <div>
                                <button
                                    type="submit"
                                    className="w-full px-4 py-2 text-lg font-semibold text-white transition-colors duration-300 bg-blue-500 rounded-md shadow hover:bg-blue-600 focus:outline-none focus:ring-blue-200 focus:ring-4"
                                >
                                    Log in
                                </button>
                            </div>
                            <div className="flex flex-col space-y-5">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Login;
