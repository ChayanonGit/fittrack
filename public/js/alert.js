// sweetalert.js

function successAlert(message) {
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: message,
        timer: 2000,
        showConfirmButton: false
    });
}

function errorAlert(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        timer: 2000,
        showConfirmButton: false
    });
}



document.addEventListener('DOMContentLoaded', function () {
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // ป้องกันลิงก์ไปเลย

            const url = this.getAttribute('href');
            const name = this.getAttribute('data-name');

            Swal.fire({
                title: `Confirm Delete ${name}?`,
                text: "ข้อมูลนี้จะไม่สามารถกู้คืนได้!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgba(196, 100, 100, 1)',
                cancelButtonColor: '#5384b3ff',
                confirmButtonText: 'ลบเลย',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url; // ไปลิงก์ delete จริง
                }
            });
        });
    });
});
