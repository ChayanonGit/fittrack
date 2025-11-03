
// gen csrf เพราะมีการส่ง post
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// เลือกทุก input class .quantity
document.querySelectorAll('.quantity').forEach(input => {

    // เชค
    input.addEventListener('change', function() {

        
    //หา element 
        const itemDiv = this.closest('.cart-item');


        if (!itemDiv) return;

   //เอาข้อมูลทีส่งมามาเก็บ
        const code = itemDiv.dataset.code;
        const type = itemDiv.dataset.type;

        // เก็บค่าใหม่
        const quantity = this.value;

        // ส่ง ค่าใหม่ ไปอัพเดตใน cart ผ่าน API ส่งเป็น JSON มีcsrf
        fetch(`/cart/update/${type}/${code}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': token 
            },
            body: JSON.stringify({ quantity }) // ส่งข้อมูลจำนวนใหม่
        })
        .then(res => {
            // แจ้ง error
            if (!res.ok) throw new Error('HTTP error ' + res.status);
            return res.json(); // แปลง response เป็น JSON
        })
        .then(data => {
            // อัพเดตจำนวนเงินของสินค้าตัวนั้น
            // เปลี่ยนจาก .total → .item-total ตามโครงสร้างใหม่
            itemDiv.querySelector('.item-total').innerText = data.total;

            // อัพเดตจำนวนเงินรวม
            document.getElementById('grand-total').innerText = data.grandTotal;
        })
        .catch(err => console.error(err)); // ถ้า error ก็แสดงใน console
    });
});
