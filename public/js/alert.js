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

function confirmDelete(formId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
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
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
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
