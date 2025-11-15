export default class ApiService {
    constructor() {
        this.baseUrl = import.meta.env.VITE_BACKEND_URL;
    }

    async request(url, method = "GET", data = null) {
        const token = sessionStorage.getItem("api_token");

        const headers = {
            "Content-Type": "application/json",
            Accept: "application/json",
        };

        if (token) {
            headers["Authorization"] = `Bearer ${token}`;
        }

        const response = await fetch(`${this.baseUrl}${url}`, {
            method,
            headers,
            body: data ? JSON.stringify(data) : null,
        });

        return response.json();
    }
}

export const api = new ApiService();
