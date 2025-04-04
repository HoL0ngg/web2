document.querySelectorAll('.plus').forEach(button => {
    button.addEventListener('click', function () {

        const quantityElement = this.previousElementSibling;
        let currentQuantity = parseInt(quantityElement.textContent);
        quantityElement.textContent = currentQuantity + 1;

        // Cập nhật giỏ hàng nếu cần
        updateCart();
    });
})

document.querySelectorAll('.minus').forEach(button => {
    button.addEventListener('click', function () {
        const quantityElement = this.nextElementSibling;
        let currentQuantity = parseInt(quantityElement.textContent);

        if (currentQuantity > 1) {
            quantityElement.textContent = currentQuantity - 1;

            // Cập nhật giỏ hàng nếu cần
            updateCart();
        }
    });
});

document.querySelectorAll('.cart-remove').forEach(button => {
    button.addEventListener('click', function () {
        const cartItem = this.closest('.cart-item');
        cartItem.remove();

        // Cập nhật giỏ hàng nếu cần
        updateCart();
    });
})

updateCart = () => {
    const cartItems = document.querySelectorAll('.cart-item');
    let total = 0;

    cartItems.forEach(item => {
        const price = parseFloat(item.querySelector('.new-price').textContent.replace('₫', '').replace('.', ''));
        const quantity = parseInt(item.querySelector('.cart-quantity').textContent);
        total += price * quantity;
    });


    document.querySelector('.total-price').textContent = total.toLocaleString('vi-VN') + '₫';
}

document.getElementById('cart-thanhtoan').addEventListener('click', function () {
    const cartItems = document.querySelectorAll('.cart-item');
    if (cartItems.length === 0) {
        alert('Giỏ hàng của bạn đang trống!');
        return;
    }

    // Chuyển hướng đến trang thanh toán
    window.location.href = 'cart.php?action=thanhtoan';
})