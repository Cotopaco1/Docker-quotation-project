import axios from "axios";
import Swal from "sweetalert2";
import { ref } from "vue";

export function RequestService() {
    const loading = ref(false);
    const errors = ref(null);

    const request = async (url, data = null, method = "get", alert = true) => {
        loading.value = true;
        try {
            const response = await axios({
                method,
                url: `${url}`,
                data
            });
            return response.data;
        } catch (err) {
            errors.value = err.response.data.errors;
            if (alert) {
                Swal.fire({
                    icon: "error",
                    title: "Oops... Status: " + err.response.status,
                    text: err.response.data.message,
                });
            }
            throw err; // Lanzar la excepción para que el flujo de control se detenga
        } finally {
            loading.value = false;
        }
    };

    return { loading, errors, request };
}