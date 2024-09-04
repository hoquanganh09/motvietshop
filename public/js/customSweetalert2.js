function toast(title = "", icon = "success", config = {}) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        },
        ...config,
    });
    Toast.fire({
        icon: icon,
        title: title,
    });
}

function showConfirm(title = null, callback = undefined) {
    title = title || "Bạn có chắc chắn không?";
    Swal.fire({
        title: title,
        showCancelButton: true,
        confirmButtonText: "Xác nhận",
        cancelButtonText: "Hủy",
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}
