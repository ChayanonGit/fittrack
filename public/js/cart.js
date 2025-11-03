const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

document.querySelectorAll('.quantity').forEach(input => {
    input.addEventListener('change', function() {
        const itemDiv = this.closest('.cart-item'); // เปลี่ยนจาก tr เป็น .cart-item
        if (!itemDiv) return; // ป้องกัน error
        const code = itemDiv.dataset.code;
        const type = itemDiv.dataset.type;
        const quantity = this.value;

        fetch(`/cart/update/${type}/${code}`, {
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
            itemDiv.querySelector('.item-total').innerText = data.total; // เปลี่ยน .total → .item-total
            document.getElementById('grand-total').innerText = data.grandTotal;
        })
        .catch(err => console.error(err));
    });
});


