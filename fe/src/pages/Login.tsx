import React from "react";

export interface LoginProps {
    email: string;
    password: string;
}

const Login: React.FC<LoginProps> = ({ email, password}) => {
    return (
        <>
            <h2>Login Page</h2>
        </>
    );
};

export default Login;
