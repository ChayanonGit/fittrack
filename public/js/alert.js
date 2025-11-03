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



// รอให้หน้าเว็บโหลด HTML
document.addEventListener('DOMContentLoaded', function () {

    // เก็บปุ่มลบ class btn-delete 
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {

        // ตรวจการคลิกแต่ละปุ่ม
        button.addEventListener('click', function (e) {
            e.preventDefault(); // เอาไว้กันไม่ให้มันลิงค์ไปหน้าเว็บก่อน

            // ดึง URL จาก href ของปุ่มมาลบ
            const url = this.getAttribute('href');

        
            const name = this.getAttribute('data-name');

            // แสดงกล่องยืนยันการลบด้วย SweetAlert (หน้าตาดูดีแทน confirm ปกติ)
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
                // เชคว่ามีการกดยืนยัน
                if (result.isConfirmed) {
                    //ตาม urlไปลบ
                    window.location.href = url;
                }
            });
        });
    });
});

