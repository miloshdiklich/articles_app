import { useLocation, useNavigate } from "react-router-dom";
import { useEffect } from "react";
import Login from "@pages/Login.tsx";
import { useAuth } from "../hooks/useAuth.ts";

function App() {
    
    const { getMe: { data: me, error: getMeError }} = useAuth();
    
    const navigate = useNavigate();
    const location = useLocation();
    
    useEffect(() => {
        if(me && location.pathname === "/") {
            navigate("/dashboard");
        }
    }, [me, location, navigate]);
    
    if(getMeError) {
        return <Login />;
    }
    
    
    return (
        <>
            { me && <h2>Hello {me.name}</h2> }
        </>
    );
}

export default App;
