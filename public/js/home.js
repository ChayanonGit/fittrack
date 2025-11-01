document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('loginModal');
    const btn = document.getElementById('loginBtn');
    const span = modal.querySelector('.close');

    btn.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    span.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    });
});
