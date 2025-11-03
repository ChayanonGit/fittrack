// รอให้หน้าเว็บโหลด HTML เสร็จก่อนค่อยรันโค้ด
document.addEventListener('DOMContentLoaded', function () {

  // ดึง element ของ modal login
  const modal = document.getElementById('loginModal');

  // ดึงปุ่ม login ที่จะกดเพื่อเปิด modal
  const btn = document.getElementById('loginBtn');

  // ดึงปุ่ม close ใน modal
  const closeBtn = modal.querySelector('.close');

  // พอกดปุ่ม login ให้เปิด modal
  btn.addEventListener('click', () => {
    modal.classList.add('show'); // เพิ่ม class 'show' ให้ modal มองเห็น
  });

  // พอกดปุ่ม close ใน modal ให้ปิด modal
  closeBtn.addEventListener('click', () => {
    modal.classList.remove('show'); // เอา class 'show' ออก → ซ่อน modal
  });

  // คลิกที่พื้นที่รอบ modal (overlay) ก็ปิด modal ได้
  window.addEventListener('click', (e) => {
    if (e.target === modal) { // ถ้าคลิกตรง modal ตัว overlay
      modal.classList.remove('show'); // ซ่อน modal
    }
  });
});

// ----------------------------------------------
// สไลด์โชว์อัตโนมัติ (Radio Button Slider)

// เริ่มนับจาก 1
var count = 1;

// ตั้ง interval ทุก 2.5 วินาที
setInterval(function() {

    // ให้ radio button ที่ตรงกับ count ถูกเลือก
    document.getElementById('radio' + count).checked = true;

    // เพิ่ม count ไป radio ตัวถัดไป
    count++;

    // ถ้าเกิน 3 ตัว ให้เริ่มใหม่ที่ 1
    if (count > 3) {
        count = 1;
    }

}, 2500); // 2500ms = 2.5 วินาที
