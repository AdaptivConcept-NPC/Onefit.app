const API_URL = ''; // Relative path because of proxy

export const authService = {
    login: async (email, password) => {
        const formData = new FormData();
        formData.append('onefitUserEmail', email);
        formData.append('onefitUserPassword', password);

        try {
            const response = await fetch(`${API_URL}/scripts/php/main_app/compile_content/profile_tab/login.php`, {
                method: 'POST',
                body: formData, // Fetch automatically sets Content-Type to multipart/form-data excluding boundary if we don't set it manually, which is correct
            });

            // The PHP script likely redirects or returns HTML. 
            // We will need to adapt the PHP to return JSON or handle the HTML response.
            // For now, we return the text.
            return await response.text();
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
            const response = await fetch(`${API_URL}/scripts/php/main_app/data_management/system_admin/user_registration/register_user.php`, {
                method: 'POST',
                body: formData,
            });
            return await response.text();
        } catch (error) {
            console.error("Registration error:", error);
            throw error;
        }
    }
};
