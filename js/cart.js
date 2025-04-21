document.querySelectorAll('.plus').forEach(button => {
    button.addEventListener('click', function () {

        const quantityElement = this.previousElementSibling;
        let currentQuantity = parseInt(quantityElement.textContent);
        quantityElement.textContent = currentQuantity + 1;

        const id = this.parentElement.dataset.id;
        const quantity = parseInt(quantityElement.textContent);

        fetch('cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `action=update&id=${id}&quantity=${quantity}`
        })

        // Cập nhật giỏ hàng nếu cần
        updateCart();
    });
})


document.querySelectorAll('.minus').forEach(button => {
    button.addEventListener('click', function () {
        const quantityElement = this.nextElementSibling;
        let currentQuantity = parseInt(quantityElement.textContent);

        if (currentQuantity > 1) {
            const id = this.parentElement.dataset.id;
            quantityElement.textContent = currentQuantity - 1;
            fetch('cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=update&id=${id}&quantity=${currentQuantity - 1}`
            })
            // Cập nhật giỏ hàng nếu cần
            updateCart();
        }
    });
});

document.querySelectorAll('.cart-remove').forEach(button => {
    button.addEventListener('click', function () {
        const id = this.dataset.id;

        fetch('cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `action=remove&id=${id}`
        })
        const cartItem = this.closest('.cart-item');
        cartItem.remove();

        // Cập nhật giỏ hàng nếu cần
        updateCart();
    });
})

updateCart = () => {
    const cartItems = document.querySelectorAll('.cart-item');
    let total = 0;
    // const cartCount = fetch('cart.php?action=getCartCount');

    if (cartItems.length === 0) {
        document.getElementById('cart-info').style.display = 'none';
        document.getElementById('cart_empty_container').style.display = 'flex';
    }
    let cartCount = 0;

    cartItems.forEach(item => {
        const price = parseFloat(item.querySelector('.new-price').textContent.replace('đ', '').replace('.', ''));
        const quantity = parseInt(item.querySelector('.cart-quantity').textContent);
        total += price * quantity;
        cartCount += quantity;
    });
    document.querySelector('#cart-count').textContent = cartCount;
    document.querySelector('.total-price').textContent = total.toLocaleString('vi-VN') + ' VNĐ';
}


if (document.getElementById('cart-thanhtoan')) document.getElementById('cart-thanhtoan').addEventListener('click', function () {
    const cartItems = document.querySelectorAll('.cart-item');
    if (cartItems.length === 0) {
        alert('Giỏ hàng của bạn đang trống!');
        return;
    }
    fetch('/handles/getSession.php')
        .then(res => res.json())
        .then(data => {
            console.log(data);
            // return;
            if (!data.success) {
                showToast('Vui lòng đăng nhập để thanh toán', false);
                return;
            } else
                window.location.href = 'cart.php?action=thanhtoan';
        })

    // Chuyển hướng đến trang thanh toán
})

window.addEventListener('load', function () {
    updateCart();
});