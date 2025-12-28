const API_URL = ''; // Relative path because of proxy

export const authService = {
    login: async (email, password) => {
        try {
            // Point to the NEW backend API
            const response = await fetch(`${API_URL}/backend/api/auth/login.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ onefitUserEmail: email, onefitUserPassword: password }),
            });

            const data = await response.json();
            if (!data.success) {
                throw new Error(data.message || "Login failed");
            }
            return data;
        } catch (error) {
            console.error("Login error:", error);
            throw error;
        }
    },

    register: async (userData) => {
        const formData = new FormData();
        // Append all keys from userData object to formData
        Object.keys(userData).forEach(key => {
            formData.append(key, userData[key]);
        });

        try {
            // Using JSON for consistency with new backend
            const response = await fetch(`${API_URL}/backend/api/auth/register.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData),
            });
            const data = await response.json();
            return data;
        } catch (error) {
            console.error("Registration error:", error);
            throw error;
        }
    }
};
