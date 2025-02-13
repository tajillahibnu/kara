// assets/custom/axiosHelper.js

// Menggunakan axios untuk melakukan permintaan GET
export const getData = async (url) => {
    try {
        const response = await axios.get(url);
        return response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
        throw error; // Melemparkan error untuk penanganan lebih lanjut
    }
};

// Menggunakan axios untuk melakukan permintaan POST
export const postData = async (url, data) => {
    try {
        const response = await axios.post(url, data);
        return response.data;
    } catch (error) {
        console.error('Error posting data:', error);
        throw error; // Melemparkan error untuk penanganan lebih lanjut
    }
};
