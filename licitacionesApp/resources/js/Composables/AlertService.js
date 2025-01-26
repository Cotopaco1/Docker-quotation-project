import Swal from "sweetalert2";
export function alertSuccess(message) {
    Swal.fire({
        position: "top-end",
        icon: "success",
        title: message ?? '',
        showConfirmButton: false,
        timer: 1500
    });

}
export function alerError(message){
    Swal.fire({
        position: "top-end",
        icon: "error",
        title: message ?? '',
        showConfirmButton: false,
        timer: 1500
    });
}