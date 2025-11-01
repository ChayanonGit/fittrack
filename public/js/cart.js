const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.querySelectorAll('.quantity').forEach(input => {
    input.addEventListener('change', function() {
        const tr = this.closest('tr');
        const code = tr.dataset.code;
        const quantity = this.value;

        fetch(`/cart/update/${code}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({ quantity })
        })
        .then(res => {
            if (!res.ok) throw new Error('HTTP error ' + res.status);
            return res.json();
        })
        .then(data => {
            tr.querySelector('.total').innerText = data.total;
            document.getElementById('grand-total').innerText = data.grandTotal;
        })
        .catch(err => console.error(err));
    });
});
