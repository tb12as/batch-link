import axios from "axios";
import auth from "./store/modules/auth";

const api = axios.create({
    baseURL: process.env.MIX_BASE_URL,
    headers: {
        "Content-Type": "application/json"
    }
});

api.interceptors.response.use(
    response => response,
    error => {
        const statusCode = error.response ? error.response.status : null;
        if (statusCode === 401) {
            auth.state.status = false;
        }
        throw error;
    }
);

export default api;
