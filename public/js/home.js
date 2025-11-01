document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('loginModal');
  const btn = document.getElementById('loginBtn');
  const closeBtn = modal.querySelector('.close');

  btn.addEventListener('click', () => {
    modal.classList.add('show');
  });

  closeBtn.addEventListener('click', () => {
    modal.classList.remove('show');
  });

  // คลิกที่ overlay ปิด modal
  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.classList.remove('show');
    }
  });
});
