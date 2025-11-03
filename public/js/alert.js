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



// รอให้หน้าเว็บโหลด HTML ทั้งหมดเสร็จก่อนค่อยทำงาน (ป้องกันปัญหา element ยังไม่เกิด)
document.addEventListener('DOMContentLoaded', function () {

    // เก็บปุ่มทั้งหมดที่มี class ชื่อ .btn-delete (ปุ่มลบแต่ละอัน)
    const deleteButtons = document.querySelectorAll('.btn-delete');

    // วนลูปปุ่มลบทั้งหมด
    deleteButtons.forEach(button => {

        // พอมีการคลิกปุ่มลบแต่ละอัน
        button.addEventListener('click', function (e) {
            e.preventDefault(); // ป้องกันไม่ให้ลิงก์เด้งไปที่ href ทันที

            // ดึง URL ที่จะลบออกมาจากค่าใน href ของปุ่ม
            const url = this.getAttribute('href');

            // ดึงชื่อสิ่งที่จะลบ (เช่น ชื่อสินค้า / คอร์ส) จาก data-name ที่ฝังอยู่ในปุ่ม
            const name = this.getAttribute('data-name');

            // แสดงกล่องยืนยันการลบด้วย SweetAlert (หน้าตาดูดีแทน confirm ปกติ)
            Swal.fire({
                title: `Confirm Delete ${name}?`, // แสดงชื่อสิ่งที่จะลบในหัวข้อ
                text: "ข้อมูลนี้จะไม่สามารถกู้คืนได้!", // ข้อความเตือนว่าลบแล้วหายถาวร
                icon: 'warning', // ใช้ไอคอนเตือนสีเหลือง
                showCancelButton: true, // ให้มีปุ่มยกเลิกด้วย
                confirmButtonColor: 'rgba(196, 100, 100, 1)', // สีปุ่มยืนยัน (แดง)
                cancelButtonColor: '#5384b3ff', // สีปุ่มยกเลิก (น้ำเงิน)
                confirmButtonText: 'ลบเลย', // ข้อความบนปุ่มยืนยัน
                cancelButtonText: 'ยกเลิก' // ข้อความบนปุ่มยกเลิก
            }).then((result) => {
                // ถ้าผู้ใช้กดยืนยันจริง ๆ
                if (result.isConfirmed) {
                    // ให้เบราว์เซอร์ไปที่ URL ของการลบ (เช่น /delete/123)
                    window.location.href = url;
                }
            });
        });
    });
});

