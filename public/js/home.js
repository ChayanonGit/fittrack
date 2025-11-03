// รันโค้ดหลังจากโหลดหน้าเสด
document.addEventListener('DOMContentLoaded', function () {

  // ดึง element ของ modal login
  const modal = document.getElementById('loginModal');

  // ดึงปุ่ม login ที่จะกดเพื่อเปิด modal
  const btn = document.getElementById('loginBtn');

  const closeBtn = modal.querySelector('.close');

  // ถ้ากดปุ่ม login ให้เปิด modal
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

//ให้เริ่มจาก 1
var count = 1;

// ตั้ง การห่างกัน ทุก 2.5 วินาที
setInterval(function() {

    // ให้ radio button ที่ตรงกับ count ที่เลือก
    document.getElementById('radio' + count).checked = true;

    // เพิ่ม count ไป radio ตัวถัดไป
    count++;


    if (count > 3) {
        count = 1;
    }

}, 2500); //  2.5 วินาที
