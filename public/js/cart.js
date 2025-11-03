// ดึงค่า CSRF token จาก meta tag ในหน้า HTML
// ใช้ป้องกันการโจมตี CSRF เวลาส่ง POST request
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// เลือกทุก input ที่มี class .quantity (ช่องกรอกจำนวนสินค้า)
document.querySelectorAll('.quantity').forEach(input => {

    // ถ้ามีการเปลี่ยนแปลงค่าในช่องกรอกจำนวน
    input.addEventListener('change', function() {

        // หา element พ่อแม่ที่ใกล้ที่สุดที่มี class .cart-item
        // (แทนจาก tr เป็น div .cart-item)
        const itemDiv = this.closest('.cart-item');

        // ถ้าไม่เจอ .cart-item ให้หยุดทำงานตรงนี้เลย ป้องกัน error
        if (!itemDiv) return;

        // ดึงข้อมูล code และ type ของสินค้าเก็บไว้
        // ข้อมูลพวกนี้มากับ attribute data-code และ data-type ของ .cart-item
        const code = itemDiv.dataset.code;
        const type = itemDiv.dataset.type;

        // ดึงจำนวนใหม่จาก input
        const quantity = this.value;

        // ส่ง request ไปอัพเดตจำนวนใน cart ผ่าน API
        fetch(`/cart/update/${type}/${code}`, {
            method: 'POST', // ใช้ POST เพราะเราแก้ไขข้อมูล
            headers: {
                'Content-Type': 'application/json', // ส่งเป็น JSON
                'X-CSRF-TOKEN': token // ใส่ CSRF token เพื่อความปลอดภัย
            },
            body: JSON.stringify({ quantity }) // ส่งข้อมูลจำนวนใหม่
        })
        .then(res => {
            // ถ้า server ตอบไม่โอเค ให้โยน error
            if (!res.ok) throw new Error('HTTP error ' + res.status);
            return res.json(); // แปลง response เป็น JSON
        })
        .then(data => {
            // อัพเดตจำนวนเงินของสินค้าตัวนั้น
            // เปลี่ยนจาก .total → .item-total ตามโครงสร้างใหม่
            itemDiv.querySelector('.item-total').innerText = data.total;

            // อัพเดตจำนวนเงินรวมทั้งหมดของตะกร้า
            document.getElementById('grand-total').innerText = data.grandTotal;
        })
        .catch(err => console.error(err)); // ถ้า error ก็แสดงใน console
    });
});
